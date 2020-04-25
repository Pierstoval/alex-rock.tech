(function () {
    if (!document.getElementById('number-of-students')) {
        return;
    }
    const number_of_students_input = document.getElementById('number-of-students');
    const number_of_days_input = document.getElementById('number-of-days');
    const number_of_days_value_container = document.getElementById('number-of-days-value');
    const final_price_container = document.getElementById('final-price');
    const trainings_list_container = document.getElementById('trainings-list-container');
    const training_booking_button = document.getElementById('training-booking-button');
    const training_booking_base_url = training_booking_button.getAttribute('data-href-base');
    const trainings_list_elements_container = trainings_list_container.querySelector('.trainings-list');
    const training_items = document.querySelectorAll('.training-item');

    function recalculatePrice() {
        const number_of_students = number_of_students_input.value;
        const selected_items = document.querySelectorAll('.training-item.selected');
        let number_of_days = number_of_days_input.value;
        const trainings_list = [];
        const trainings_ids_list = [];

        if (selected_items.length) {
            number_of_days = 0;
            selected_items.forEach((training_item) => {
                const duration = parseInt(training_item.getAttribute('data-duration'));

                if (isNaN(duration)) {
                    throw new Error('Cannot evaluate training duration.');
                }

                number_of_days += duration;

                trainings_list.push(training_item.querySelector('.card-title').innerText);
                trainings_ids_list.push(training_item.getAttribute('data-training'));
            });

            number_of_days_input.setAttribute('disabled', 'disabled');
            number_of_days_input.classList.add('disabled');
            number_of_days_input.value = number_of_days;
            number_of_days_value_container.innerText = number_of_days;
            trainings_list_container.classList.remove('hide');
            trainings_list_elements_container.innerHTML = trainings_list.map((i) => '<li>' + i + '</li>').join("\n");

            const url = new URL(training_booking_base_url);
            url.searchParams.append('nos', number_of_students);
            trainings_ids_list.forEach((training_item) => {
                url.searchParams.append('tr[]', training_item);
            });

            training_booking_button.href = url;
        } else {
            number_of_days_input.removeAttribute('disabled');
            number_of_days_input.classList.remove('disabled');
            trainings_list_container.classList.add('hide');
            trainings_list_elements_container.innerHTML = '';
            training_booking_button.href = training_booking_base_url;
        }

        const final_price = trainingPrice(number_of_students, number_of_days);

        if (!final_price) {
            throw new Error('No price for this amount of students or days.');
        }

        final_price_container.innerText = final_price + ' €';
    }

    number_of_students_input.addEventListener('input', () => recalculatePrice());
    number_of_days_input.addEventListener('input', () => recalculatePrice());

    training_items.forEach((training_item) => {
        training_item.addEventListener('click', () => {
            if (training_item.classList.contains('selected')) {
                training_item.classList.remove('selected');
            } else {
                training_item.classList.add('selected');
            }
            recalculatePrice();
        });
    });

    function trainingPrice(numberOfStudents, numberOfDays) {
        numberOfStudents = parseInt(numberOfStudents, 10);
        numberOfDays = parseInt(numberOfDays, 10);
        if (isNaN(numberOfStudents) || isNaN(numberOfDays)) {
            throw 'Invalid number of students/days.';
        }
        if (!numberOfDays || !numberOfStudents) {
            return null;
        }

        const dailyRate = 200;
        const regressionFactor = 0.5;

        return (dailyRate * (numberOfStudents + numberOfDays)) * (1 + regressionFactor);
    }

    recalculatePrice();
})();
