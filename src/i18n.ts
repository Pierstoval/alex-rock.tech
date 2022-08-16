import {addMessages} from 'svelte-i18n';
import { dictionary as fr } from './translations/_fr';
import { dictionary as en } from './translations/_en';

addMessages('fr', fr);
addMessages('en', en);
