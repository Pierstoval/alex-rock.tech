import resolve from '@rollup/plugin-node-resolve';
import replace from '@rollup/plugin-replace';
import commonjs from '@rollup/plugin-commonjs';
import svelte from 'rollup-plugin-svelte';
import babel from '@rollup/plugin-babel';
import copy from 'rollup-plugin-copy';
import { terser } from 'rollup-plugin-terser';
import config from 'sapper/config/rollup.js';
import pkg from './package.json';
import autoPreprocess from 'svelte-preprocess';

const mode = process.env.NODE_ENV;
const dev = mode === 'development';
const legacy = !!process.env.SAPPER_LEGACY_BUILD;

const onwarn = (warning, onwarn) => {
	if (warning.code === 'CIRCULAR_DEPENDENCY' && /[/\\]@sapper[/\\]/.test(warning.message)){
		return;
	}
	if (/Unused CSS selector|The 'this' keyword is equivalent to 'undefined' at the top level of an ES module, and has been rewritten/gi.test(warning.message)){
		return;
	}
	return onwarn(warning);
};

const preprocessOptions = {
	scss: {
		failOnError: true,
		includePaths: ['assets', 'src', 'node_modules'],
	}
};

export default {
	client: {
		input: config.client.input(),
		output: config.client.output(),
		context: "window",
		plugins: [
			replace({
				'process.browser': true,
				'process.env.NODE_ENV': JSON.stringify(mode)
			}),
			svelte({
				dev,
				hydratable: true,
				emitCss: true,
				preprocess: autoPreprocess(preprocessOptions),
			}),
			resolve({
				browser: true,
				dedupe: ['svelte']
			}),
			commonjs(),

			copy({
				targets: [
					{ src: 'node_modules/@fortawesome/fontawesome-free/webfonts/', dest: 'static/' },
					{ src: 'node_modules/jquery/dist/*', dest: 'static/js/' },
					{ src: 'node_modules/bootstrap/dist/js/*', dest: 'static/js/' }
				],
				copyOnce: true
			}),

			legacy && babel({
				extensions: ['.js', '.mjs', '.html', '.svelte'],
				babelHelpers: 'runtime',
				exclude: ['node_modules/@babel/**'],
				presets: [
					['@babel/preset-env', {
						targets: '> 0.25%, not dead'
					}]
				],
				plugins: [
					'@babel/plugin-syntax-dynamic-import',
					['@babel/plugin-transform-runtime', {
						useESModules: true
					}]
				]
			}),

			!dev && terser({
				module: true
			})
		],

		preserveEntrySignatures: false,
		onwarn,
	},

	server: {
		input: config.server.input(),
		output: config.server.output(),
		plugins: [
			replace({
				'process.browser': false,
				'process.env.NODE_ENV': JSON.stringify(mode)
			}),
			svelte({
				generate: 'ssr',
				dev,
				preprocess: autoPreprocess(preprocessOptions),
			}),
			resolve({
				dedupe: ['svelte']
			}),
			commonjs(),
		],
		external: Object.keys(pkg.dependencies).concat(
			require('module').builtinModules || Object.keys(process.binding('natives'))
		),

		preserveEntrySignatures: 'strict',
		onwarn,
	},

	serviceworker: {
		input: config.serviceworker.input(),
		output: config.serviceworker.output(),
		plugins: [
			resolve(),
			replace({
				'process.browser': true,
				'process.env.NODE_ENV': JSON.stringify(mode)
			}),
			commonjs(),
			!dev && terser(),
		],

		preserveEntrySignatures: false,
		onwarn,
	}
};
