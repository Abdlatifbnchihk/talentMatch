## Why

The Vite build fails because PostCSS cannot find the `autoprefixer` module. The `postcss.config.js` file references autoprefixer but it's not installed, preventing frontend asset compilation.

## What Changes

- Add `autoprefixer` to package.json devDependencies
- Run npm install to install the missing dependency

## Capabilities

### New Capabilities
- `autoprefixer-dependency`: Add missing autoprefixer package for PostCSS

### Modified Capabilities
<!-- None -->

## Impact

- **Dependencies**: Adds autoprefixer ^10.4.2 to devDependencies
- **Build System**: Fixes Vite/PostCSS build process
