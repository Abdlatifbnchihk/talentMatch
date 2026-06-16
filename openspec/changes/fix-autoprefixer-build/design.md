## Context

The postcss.config.js file requires the autoprefixer plugin but it's not installed. This causes the Vite build to fail with "Cannot find module 'autoprefixer'".

## Goals / Non-Goals

**Goals:**
- Add autoprefixer dependency to fix the build

**Non-Goals:**
- Modify PostCSS configuration
- Change build system

## Decisions

### Decision 1: Add autoprefixer to package.json
**Choice**: Add autoprefixer ^10.4.2 as devDependency
**Rationale**: Matches Laravel Breeze's expected configuration

## Risks / Trade-offs

- **Risk**: None significant
  **Mitigation**: Standard Laravel Breeze dependency
