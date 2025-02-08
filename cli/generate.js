const inquirer = require("inquirer");
const fs = require("fs").promises;
const path = require("path");
const chalk = require("chalk");

const MODELS_PATH = path.join(__dirname, "../inc/Models");
const VIEWS_PATH = path.join(__dirname, "../views/components");

// Helper functions for name formatting
function toKebabCase(str) {
  return str
    .replace(/([a-z])([A-Z])/g, "$1-$2")
    .replace(/[\s_]+/g, "-")
    .toLowerCase();
}

function toPascalCase(str) {
  return str
    .replace(/[-\s_]+(.)?/g, (_, c) => (c ? c.toUpperCase() : ""))
    .replace(/^./, (s) => s.toUpperCase());
}

function toSnakeCase(str) {
  return str
    .replace(/([a-z])([A-Z])/g, "$1_$2")
    .replace(/[\s-]+/g, "_")
    .toLowerCase();
}

async function checkExists(dir) {
  try {
    await fs.access(dir);
    return true;
  } catch {
    return false;
  }
}

async function createDirectory(dir) {
  try {
    await fs.mkdir(dir, { recursive: true });
    console.log(chalk.green(`Created directory: ${dir}`));
  } catch (err) {
    console.error(chalk.red(`Error creating directory: ${err.message}`));
    throw err;
  }
}

function generateVariantContent(modelName, variantName) {
  const pascalModelName = toPascalCase(modelName);
  const pascalVariantName = toPascalCase(variantName);
  const snakeModelName = toSnakeCase(modelName);
  const snakeVariantName = toSnakeCase(variantName);

  return `<?php
namespace VillaCapriani\\Models\\Components\\${pascalModelName}\\Variants;

class ${pascalVariantName} {
  public static function getId() {
    return '${toKebabCase(variantName)}';
  }

  public static function getLabel() {
    return '${variantName}';
  }

  public static function getFields() {
    return [
      [
        'key' => 'field_${snakeModelName}_${snakeVariantName}_content',
        'label' => 'Content',
        'name' => 'content',
        'type' => 'group',
        'sub_fields' => [
          [
            'key' => 'field_${snakeModelName}_${snakeVariantName}_heading',
            'label' => 'Heading',
            'name' => 'heading',
            'type' => 'text',
            'required' => 1
          ],
          [
            'key' => 'field_${snakeModelName}_${snakeVariantName}_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'required' => 1
          ]
        ]
      ]
    ];
  }
}
`;
}

function generateControllerContent(modelName, variants) {
  const pascalModelName = toPascalCase(modelName);
  const snakeModelName = toSnakeCase(modelName);

  const variantImports = variants
    .map(
      (v) =>
        `use VillaCapriani\\Models\\Components\\${pascalModelName}\\Variants\\${toPascalCase(
          v
        )};`
    )
    .join("\n");

  const variantsList = variants
    .map((v) => `      ${toPascalCase(v)}::class,`)
    .join("\n");

  return `<?php
namespace VillaCapriani\\Models\\Components\\${pascalModelName};

${variantImports}

class Controller {
  public static function getLayout() {
    return [
      'key' => 'layout_${snakeModelName}',
      'name' => '${toKebabCase(modelName)}',
      'label' => '${modelName}',
      'sub_fields' => array_merge(
        self::getCommonFields(),
        self::getVariantFields()
      )
    ];
  }

  private static function getCommonFields() {
    return [
      [
        'key' => 'field_${snakeModelName}_variant',
        'label' => 'Variant',
        'name' => 'variant',
        'type' => 'select',
        'choices' => self::getVariantOptions(),
        'required' => 1,
      ]
    ];
  }

  private static function getVariantFields() {
    $fields = [];
    $variants = self::getVariants();
    
    foreach ($variants as $variant) {
      if (method_exists($variant, 'getFields')) {
        $variantFields = $variant::getFields();
        foreach ($variantFields as $field) {
          $field['conditional_logic'] = [
            [
              [
                'field' => 'field_${snakeModelName}_variant',
                'operator' => '==',
                'value' => $variant::getId(),
              ]
            ]
          ];
          $fields[] = $field;
        }
      }
    }
    
    return $fields;
  }

  private static function getVariants() {
    return [
${variantsList}
    ];
  }

  private static function getVariantOptions() {
    $options = [];
    foreach (self::getVariants() as $variant) {
      $options[$variant::getId()] = $variant::getLabel();
    }
    return $options;
  }
}
`;
}

function generateViewTemplate(modelName, variantName) {
  const kebabModelName = toKebabCase(modelName);
  const kebabVariantName = toKebabCase(variantName);

  return `<div class="${kebabModelName}-${kebabVariantName}">
  {% if content %}
    <div class="content">
      {% if content.heading %}
        <h2>{{ content.heading }}</h2>
      {% endif %}
      
      {% if content.description %}
        <p>{{ content.description }}</p>
      {% endif %}
    </div>
  {% endif %}
</div>
`;
}

async function generateFiles(modelName, variants) {
  const pascalModelName = toPascalCase(modelName);

  // Create model directory
  const modelDir = path.join(MODELS_PATH, pascalModelName);
  const variantsDir = path.join(modelDir, "Variants");
  await createDirectory(variantsDir);

  // Create view directory
  const viewDir = path.join(VIEWS_PATH, toKebabCase(modelName));
  await createDirectory(viewDir);

  // Generate controller
  await fs.writeFile(
    path.join(modelDir, "controller.php"),
    generateControllerContent(modelName, variants)
  );

  // Generate variant files
  for (const variant of variants) {
    // Create variant PHP file
    await fs.writeFile(
      path.join(variantsDir, `${toPascalCase(variant)}.php`),
      generateVariantContent(modelName, variant)
    );

    // Create variant view template
    await fs.writeFile(
      path.join(viewDir, `${toKebabCase(variant)}.twig`),
      generateViewTemplate(modelName, variant)
    );
  }
}

async function main() {
  try {
    const { modelName } = await inquirer.prompt([
      {
        type: "input",
        name: "modelName",
        message: "What is the name of the Model?",
        validate: async (input) => {
          if (!input) return "Model name is required";

          const modelDir = path.join(MODELS_PATH, toPascalCase(input));
          const viewDir = path.join(VIEWS_PATH, toKebabCase(input));

          if (await checkExists(modelDir)) {
            return "Model already exists in inc/Models";
          }
          if (await checkExists(viewDir)) {
            return "Component already exists in views/components";
          }

          return true;
        },
      },
    ]);

    const { variantCount } = await inquirer.prompt([
      {
        type: "number",
        name: "variantCount",
        message: "How many variants do you want to create?",
        validate: (input) => {
          if (input < 1) return "Must create at least one variant";
          if (input > 10) return "Maximum 10 variants allowed";
          return true;
        },
      },
    ]);

    const variants = [];
    for (let i = 0; i < variantCount; i++) {
      const { variantName } = await inquirer.prompt([
        {
          type: "input",
          name: "variantName",
          message: `Name for variant #${i + 1}:`,
          validate: (input) => {
            if (!input) return "Variant name is required";
            if (variants.includes(input)) return "Variant names must be unique";
            return true;
          },
        },
      ]);
      variants.push(variantName);
    }

    await generateFiles(modelName, variants);
    console.log(chalk.green("\nModel and variants generated successfully!"));
  } catch (error) {
    console.error(chalk.red("Error:", error.message));
    process.exit(1);
  }
}

main();
