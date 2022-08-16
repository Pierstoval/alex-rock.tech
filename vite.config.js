import { sveltekit } from '@sveltejs/kit/vite';
import path from 'path';
import fs from 'fs';

const copyFile = function (options) {
	return function () {
		const targetDir = path.dirname(options.target);
		if (!fs.existsSync(targetDir)){
			fs.mkdirSync(targetDir);
		}
		fs.writeFileSync(options.target, fs.readFileSync(options.source));
	};
}

/** @type {import('vite').UserConfig} */
const config = {
	plugins: [
		copyFile({
			source:  './node_modules/@fortawesome/fontawesome-free/webfonts/',
			target: './static/',
		}),
		copyFile({
			source:  './node_modules/jquery/dist/*',
			target: './static/js/',
		}),
		copyFile({
			source:  './node_modules/bootstrap/dist/js/*',
			target: './static/js/',
		}),
		sveltekit(),
	],
};

export default config;
