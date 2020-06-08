import sirv from 'sirv';
import polka from 'polka';
import compression from 'compression';
import * as sapper from '@sapper/server';

const { PORT, NODE_ENV } = process.env;
const dev = NODE_ENV === 'development';

// Translations
import { addMessages, locale, init } from 'svelte-i18n';
import fr from './translations/_fr.js';
import en from './translations/_en.js';

function setupLocale(loc) {
	init({
		fallbackLocale: loc,
		initialLocale: loc,
	});
	addMessages('fr', fr);
	addMessages('en', en);
	locale.set(loc);
}

// import {ContactController} from './controllers/contact';

polka()
	// .get('/fr/contact', ContactController(setupLocale, 'fr'))
	// .get('/en/contact', ContactController(setupLocale, 'en'))
	.use(function (req, res, next) {
		if (req.url === '' || req.url === '/') {
			res.writeHead(302, {
				'Location': '/en',
			});
			res.end('');

			return;
		}

		// Update locale
		let loc = 'en';

		if (req.url === '' || req.url === '/') {
			req.url = '/'+loc;
		}
		if (req.url.match(/^\/(fr|en)\/?$/i)) {
			loc = req.url.replace(/^\/(fr|en)\/?.*$/i, '$1');
		}
		req.params.locale = loc;
		next();
	})
	.use(
		function (req, res, next) {
			setupLocale(req.params.locale || 'en');
			next();
		},
		compression({ threshold: 0 }),
		sirv('static', { dev }),
		sapper.middleware()
	)
	.listen(PORT, err => {
		if (err) console.log('error', err);
	});
