import Lib_menu from '../../../lib/js/lib_menu.js';
const lib = new Lib_menu();

const enabled_radio = document.getElementsByClassName('item_enabled');
let flag = true;
let enabled;

for(let i = 0; i < enabled_radio.length; i++){
  enabled_radio[i].addEventListener('click', (e) => {
    //labelのせいで処理が2回行われてしまうため、flagを使って最初の一回のみ通す
    setTimeout(() => {
      if(flag){
        flag = false;
        let menu_id = e.target.closest('.tbl_row').id;
        let elements = document.getElementsByName('radio' + menu_id);
        if(elements[0].checked){
          enabled = 1;
        }else{
          enabled = 0;
        }
        console.log('id:'+menu_id+'/enabled:'+enabled);
        let form = new FormData();
        form.append('menu_id', menu_id);
        form.append('enabled', enabled);
        lib.ajax('POST', 'https://artful.jp/staging-menu/bin/ajax/update_enabled.php', form);
      }else{
        flag = true;
      }
    }, 300);
  });
}
