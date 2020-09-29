import Lib_menu from './lib_menu.js';

export const sort = () => {
    const lib = new Lib_menu();
    const btn_sort = document.getElementById('btn_sort');
    let flg_btn = false;
    let btn_displays = [];
    let tbl_rows_displays = [];
    let btns = document.getElementsByClassName('btn');
    let tbl_rows = document.getElementsByClassName('tbl_row');
    let orders;
    btn_sort.addEventListener('click', () => {
        if(!flg_btn){
            for(let tr_i = 0; tr_i < tbl_rows.length; tr_i++){
                tbl_rows_displays.push(tbl_rows[tr_i].style.display);
                tbl_rows[tr_i].style.display = 'none';
            }
            for(let i = 0; i < btns.length; i++){
                if(btns[i] != btn_sort){
                    btn_displays.push(btns[i].style.display);
                    btns[i].style.display = 'none';
                }
                else{
                    btn_sort.innerText = '完了';
                    btn_sort.classList.add('done');
                    btn_displays.push("");
                }
            }
            let tbls = document.getElementsByClassName('tbls')[0];
            Sortable.create(tbls,{
                animation: 110,
                store: {
                    set: function (sortable) {
                        orders = sortable.toArray();
                        // localStorage.setItem(sortable.options.group.name, orders.join('|'));
                    }
                },
            });
            flg_btn = true;
        }
        else{
            let tbl_items = document.getElementsByClassName('tbl_item');
            for(let t_i = 0; t_i < tbl_items.length; t_i++){
                let data_id = tbl_items[t_i].getAttribute('data-id');
                let data_tbl = tbl_items[t_i].getAttribute('data-tbl');
                let item_id = tbl_items[t_i].id;
                let order = orders[data_id - 1];

                let form = new FormData();
                form.append('tbl', data_tbl);
                form.append('item_id', item_id);
                form.append('order', order);
                lib.ajax('POST', 'https://artful.jp/staging-menu/control/update_sort.php', form);
            }
            for(let tr_i = 0; tr_i < tbl_rows.length; tr_i++){
                tbl_rows_displays.push(tbl_rows[tr_i].style.display);
                tbl_rows[tr_i].style.display = tbl_rows_displays[tr_i];
            }
            for(let b_i = 0; b_i < btns.length; b_i++){
                if(btns[b_i] != btn_sort){
                    btns[b_i].style.display = btn_displays[b_i];
                }
                else{
                    btn_sort.innerText = '順番を変更';
                    btn_sort.classList.remove('done');
                }
            }
            flg_btn = false;
        }
    });
}