import Lib_menu from '../../../lib/js/lib_menu.js';

const enabled_radio = document.getElementsByClassName('item_enabled');

enabled_radio.addEventListener('click', () => {
  let form = new FormData();
  form.append('menu_id', menu_id);
  form.append('enabled', enabled);
  lib.ajax('GET', 'https://artful.jp/staging-menu/bin/ajax/update_enabled.php', form);
  console.log("a");
});