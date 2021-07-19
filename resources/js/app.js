require('./bootstrap')

document
    .querySelectorAll('.close-btn')
    .forEach(btn => btn.addEventListener('click', function () {
        this.closest(".close-target").classList.add("hidden")
    }))