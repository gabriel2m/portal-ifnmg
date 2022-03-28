require('./bootstrap')

/**
* Close Button
*/
{
    document
        .querySelectorAll('.close-btn')
        .forEach(btn => btn.addEventListener('click', function () {
            this
                .closest(".close-target")
                .classList
                .add("hidden")
        }))
}

/**
* Dropdown
*/
{
    document
        .querySelectorAll('.dropdown-toggle')
        .forEach(btn => btn.addEventListener('click', function () {
            this
                .closest(".dropdown")
                .querySelector('.dropdown-menu')
                .classList
                .toggle('hidden')
        }))

    let dropdowns = document.querySelectorAll('.dropdown')

    document.addEventListener('click', function (event) {
        dropdowns.forEach(function (dropdown) {
            if (!dropdown.contains(event.target)) {
                dropdown
                    .querySelector('.dropdown-menu')
                    .classList
                    .add('hidden')
            }
        })
    });
}

/**
* Show on scroll
*/
{
    const observer = new IntersectionObserver(
        function (entries) {
            entries.forEach((entry) => {
                if (entry.isIntersecting)
                    setTimeout(function () {
                        entry.target.classList.add("show");
                    }, 600);
            });
        }
    );

    document
        .querySelectorAll(".show-on-scroll")
        .forEach(function (target) {
            observer.observe(target);
        });
}

