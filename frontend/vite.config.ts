import { sveltekit } from '@sveltejs/kit/vite';
import type { Plugin } from 'vite';
import type { UserConfig } from 'vite';

import path from 'path';
import https from 'https';
import fs from 'fs-extra';

const copyFile = function (options: any): Plugin[] {
	return [{
		name: 'copy',
		configResolved: function () {
			console.info(`Copying files from "${options.source}" to "${options.target}"`)
			const targetDir = path.dirname(options.target);
			if (!fs.existsSync(targetDir)){
				fs.mkdirSync(targetDir);
			}
			fs.copySync(options.source, options.target, {overwrite: true});
		}
	}];
}

const downloadFile = function (options: any): Plugin[] {
	return [{
		name: 'download',
		configResolved: function () {
			console.info(`Downloading file from "${options.url}" to "${options.target}"`)
			const targetDir = path.dirname(options.target);
			if (!fs.existsSync(targetDir)){
				fs.mkdirSync(targetDir);
			}
			const file = fs.createWriteStream(options.target);
			https.get(options.url, function(response) {
				response.pipe(file);
				file.on("finish", () => {
					file.close();
					console.info(`Done for ${options.target}!`);
				});
			});
		}
	}];
}

const config: UserConfig = {
	plugins: [
		copyFile({
			source:  __dirname+'/node_modules/@fortawesome/fontawesome-free/webfonts/',
			target: __dirname+'/static/webfonts/',
		}),
		downloadFile({
			url: 'https://js.hcaptcha.com/1/api.js',
			target: __dirname+'/static/js/hcaptcha.js',
		}),
		sveltekit(),
	],
};

export default config;
