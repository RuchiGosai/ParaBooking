document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.sidebar ul li a');
    const sections = document.querySelectorAll('.content-section');

    links.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            links.forEach(link => link.classList.remove('active'));
            link.classList.add('active');

            const targetSection = document.querySelector(link.getAttribute('href'));
            sections.forEach(section => section.classList.remove('active'));
            targetSection.classList.add('active');
        });
    });

    // Set the default active section
    links[0].click();
});
