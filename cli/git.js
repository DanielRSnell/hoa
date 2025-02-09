const inquirer = require('inquirer');
const { exec } = require('child_process');
const chalk = require('chalk');

async function gitCommand() {
  try {
    // First prompt for commit type
    const { commitType } = await inquirer.prompt([
      {
        type: 'list',
        name: 'commitType',
        message: 'What type of commit is this?',
        choices: ['Component'],
        default: 'Component'
      }
    ]);

    if (commitType === 'Component') {
      const { componentName } = await inquirer.prompt([
        {
          type: 'input',
          name: 'componentName',
          message: 'What is the name of the component?',
          validate: input => {
            if (!input) return 'Component name is required';
            if (!/^[a-zA-Z][a-zA-Z0-9-]*$/.test(input)) {
              return 'Component name must start with a letter and contain only letters, numbers, and hyphens';
            }
            return true;
          }
        }
      ]);

      // Execute git commands
      const gitCommands = `git add . && git commit -m "Adding ${componentName}" && git push origin main`;
      
      console.log(chalk.yellow('\nExecuting git commands...'));
      
      exec(gitCommands, (error, stdout, stderr) => {
        if (error) {
          console.error(chalk.red(`Error: ${error.message}`));
          return;
        }
        
        if (stderr) {
          console.log(chalk.yellow(`Git output: ${stderr}`));
        }
        
        if (stdout) {
          console.log(chalk.green(`Git output: ${stdout}`));
        }

        // Print the Bolt prompt template
        console.log(chalk.green('\nSuccess! Here\'s your Bolt prompt:'));
        console.log(chalk.cyan(`\nI made component ${componentName} in views, go ahead and make it dynamic and setup the model with all the fields for each variant\n`));
      });
    }
  } catch (error) {
    console.error(chalk.red('Error:', error.message));
    process.exit(1);
  }
}

module.exports = gitCommand;
