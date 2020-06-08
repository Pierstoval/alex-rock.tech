
import * as sapper from '@sapper/app';

// // Translations
import { addMessages, locale, init } from 'svelte-i18n';
import fr from './translations/_fr.js';
import en from './translations/_en.js';
addMessages('fr', fr);
addMessages('en', en);
init({
	fallbackLocale: 'en',
	initialLocale: 'en',
});
locale.set('en');

sapper.start({
	target: document.getElementById('app')
});
