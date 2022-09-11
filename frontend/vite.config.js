import { sveltekit } from '@sveltejs/kit/vite';
import path from 'path';
import fs from 'fs-extra';

const copyFile = function (options) {
	return function () {
		const targetDir = path.dirname(options.target);
		if (!fs.existsSync(targetDir)){
			fs.mkdirSync(targetDir);
		}
		fs.copySync(options.source, options.target, {overwrite: true});
	};
}

/** @type {import('vite').UserConfig} */
const config = {
	plugins: [
		copyFile({
			source:  __dirname+'/node_modules/@fortawesome/fontawesome-free/webfonts/',
			target: __dirname+'/static/webfonts/',
		}),
		copyFile({
			source:  './node_modules/jquery/dist/',
			target: './static/js/',
		}),
		copyFile({
			source:  './node_modules/bootstrap/dist/js/',
			target: './static/js/',
		}),
		copyFile({
			source:  './node_modules/startbootstrap-freelancer/dist/css/styles.css',
			target: './static/css/sbf.css',
		}),
		copyFile({
			source:  './node_modules/startbootstrap-freelancer/dist/js/scripts.js',
			target: './static/js/sbf.js',
		}),
		sveltekit(),
	],
};

export default config;
