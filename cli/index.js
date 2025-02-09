#!/usr/bin/env node

const inquirer = require('inquirer');
const generateCommand = require('./generate');
const gitCommand = require('./git');

async function main() {
  try {
    const { command } = await inquirer.prompt([
      {
        type: 'list',
        name: 'command',
        message: 'What command would you like to run?',
        choices: [
          { name: 'Generate Component', value: 'generate' },
          { name: 'Git Operations', value: 'git' }
        ]
      }
    ]);

    switch (command) {
      case 'generate':
        await generateCommand();
        break;
      case 'git':
        await gitCommand();
        break;
      default:
        console.log('Invalid command');
        process.exit(1);
    }
  } catch (error) {
    console.error('Error:', error.message);
    process.exit(1);
  }
}

main();
