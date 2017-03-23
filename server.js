#!/usr/bin/env node

let yargs = require('yargs'),
    Cli = require('./server/cli'),
    Log = require('./server/log'),
    readline = require('readline');

let cli = new Cli();

readline.emitKeypressEvents(process.stdin);
process.stdin.setRawMode(true);

/**
 * CLI Commands.
 */
let argv = yargs.usage("$0 command")
    .command("init", "Initialize server with a config file.", yargs => cli.init(yargs))
    .command("client:add", "Register a client that can make api requests.", () => cli.clientAdd(yargs))
    .command("client:remove", "Remove a client that has been registered.", yargs => cli.clientRemove(yargs))
    .command("start", "Start up the server.", cli.start)
    .demand(1, "Please provide a valid command.")
    .help("h")
    .alias("h", "help")
    .argv;

process.stdin.on('keypress', (str, key) => {
  if (key.ctrl && key.name === 'c') {
    Log.info(`Bye`);
    process.exit();
  } else {
    Log.info('Press CTRL-C to quit...');
  }
});
