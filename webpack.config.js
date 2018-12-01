const path = require('path');

module.exports = {
  entry: './src/emoteButtonsDashboard.js',
  output: {
    filename: 'emoteButton.js',
    path: path.resolve(__dirname, 'dist')
  }
};
