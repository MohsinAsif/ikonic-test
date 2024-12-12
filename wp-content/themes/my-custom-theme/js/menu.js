function my_theme_enqueue_scripts() {
    wp_enqueue_script('menu-js', get_template_directory_uri() . '/js/menu.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('.menu li.menu-item-has-children');

    menuItems.forEach(item => {
        const link = item.querySelector('a');
        const subMenu = item.querySelector('ul');

        link.addEventListener('click', function (e) {
            if (subMenu) {
                e.preventDefault();
                subMenu.classList.toggle('open');
            }
        });
    });
});
