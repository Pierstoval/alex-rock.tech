
import '../../node_modules/@fortawesome/fontawesome-free/css/all.min.css';
import '../scss/app.scss';

import '../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js';
import '../../node_modules/startbootstrap-freelancer/js/jqBootstrapValidation.min.js';
import '../../node_modules/jquery-easing/dist/jquery.easing.1.3.umd.js';
import './_contact_me.js';
import './_freelancer.js';

const ranges = document.querySelectorAll('input[type="range"]');

ranges.forEach((element) => {
    if (element.hasAttribute('data-value-container')) {
        const container = document.getElementById(element.getAttribute('data-value-container'));

        element.addEventListener('input', () => {
            container.innerText = element.value;
        });
    }
});

