/**
 * Build-time version of `php artisan client` (which needs the DB, unavailable
 * during the image build). Generates client.scss / client.js, importing only
 * the default theme parts listed in PartSeeder.php so the built CSS matches a
 * freshly seeded install. Falls back to every segment if the seeder is missing.
 * After changing theme parts in the panel, rerun `php artisan client` + rebuild.
 */
import {
  readdirSync, statSync, readFileSync, writeFileSync, existsSync, mkdirSync,
} from 'node:fs';
import { join } from 'node:path';

const root = process.cwd();
const sassDir = join(root, 'resources/sass');
const jsDir = join(root, 'resources/js');
const customScssDir = join(sassDir, 'client-custom');
const customJsDir = join(jsDir, 'client-custom');
const segmentsDir = join(root, 'resources/views/segments');
const seederPath = join(root, 'database/seeders/PartSeeder.php');

const isDir = (p) => existsSync(p) && statSync(p).isDirectory();
const bigEnough = (p) => existsSync(p) && statSync(p).size > 10;

// default theme variables, only if not already present
const appVarsFile = join(customScssDir, '_app_variables.scss');
if (!existsSync(appVarsFile)) {
  const vars = {
    'xshop-background': '#ffffff',
    'xshop-primary': '#6e0000',
    'xshop-diff': '#ffffff',
    'xshop-diff2': '#ffffff',
    'xshop-secondary': '#ff0000',
    'xshop-text': '#111111',
    'xshop-border-radius': '7px',
    'xshop-shadow': '2px 2px 4px #777777',
  };
  let out = '// generated at build time (default theme)\n';
  for (const [k, v] of Object.entries(vars)) out += `$${k}:${v};\n`;
  out += ':root{\n';
  for (const [k, v] of Object.entries(vars)) out += `--${k}:${v};\n`;
  out += '}\n\n';
  mkdirSync(customScssDir, { recursive: true });
  writeFileSync(appVarsFile, out);
  console.log('[gen-client-assets] created default _app_variables.scss');
}

// which segments/parts to import — the default set from PartSeeder.php
/** @type {{segment:string, part:string}[]} */
let parts = [];

if (existsSync(seederPath)) {
  const src = readFileSync(seederPath, 'utf8');
  // seeder sets ->segment then ->part per block; pair them in order
  const re = /\$part->(segment|part)\s*=\s*'([^']+)'/g;
  let m;
  let cur = {};
  while ((m = re.exec(src)) !== null) {
    cur[m[1]] = m[2];
    if (cur.segment && cur.part) {
      parts.push({ segment: cur.segment, part: cur.part });
      cur = {};
    }
  }
  const seen = new Set();
  parts = parts.filter((p) => {
    const k = `${p.segment}/${p.part}`;
    if (seen.has(k)) return false;
    seen.add(k);
    return true;
  });
  console.log(`[gen-client-assets] using ${parts.length} default parts from PartSeeder.php`);
}

if (parts.length === 0) {
  // fallback: every segment on disk
  console.log('[gen-client-assets] PartSeeder parts not found, importing all segments');
  if (isDir(segmentsDir)) {
    for (const seg of readdirSync(segmentsDir).sort()) {
      if (!isDir(join(segmentsDir, seg))) continue;
      for (const part of readdirSync(join(segmentsDir, seg)).sort()) {
        if (isDir(join(segmentsDir, seg, part))) parts.push({ segment: seg, part });
      }
    }
  }
}

// client.scss: custom partials + the chosen segments
let scss = '// generated file - do not edit\n';

for (const f of readdirSync(customScssDir).sort()) {
  if (f.endsWith('.scss')) {
    const name = f.replace(/^_/, '').replace(/\.scss$/, '');
    scss += `@use "client-custom/${name}";\n`;
  }
}

for (const { segment, part } of parts) {
  if (bigEnough(join(segmentsDir, segment, part, `${part}.scss`))) {
    scss += `@use "../views/segments/${segment}/${part}/${part}";\n`;
  }
}

writeFileSync(join(sassDir, 'client.scss'), scss);

// client.js: axios + custom scripts + the chosen segments
let js = '// generated file - do not edit\n'
  + "import axios from 'axios';\n"
  + 'window.axios = axios;\n'
  + "window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';\n";

if (isDir(customJsDir)) {
  for (const f of readdirSync(customJsDir).sort()) {
    if (f.endsWith('.js')) js += `import "./client-custom/${f}";\n`;
  }
}

for (const { segment, part } of parts) {
  if (bigEnough(join(segmentsDir, segment, part, `${part}.js`))) {
    js += `import "../views/segments/${segment}/${part}/${part}.js";\n`;
  }
}

writeFileSync(join(jsDir, 'client.js'), js);

console.log('[gen-client-assets] client.scss and client.js generated');
