import Lib_menu from '../../../lib/js/lib_menu.js';

export const sort_item = () => {
    let btn_sort_item = document.getElementsByClassName('btn_sort_item');
    let tbl_items = document.getElementsByClassName('items');
    let btn_displays = [];
    let sortables = [];
    let orders = [];
    for(let i = 0; i < tbl_items.length; i++){
        sortables[i] = Sortable.create(tbl_items[i],{
            animation: 110,
            store: {
                set: function (sortable) {
                    orders = sortable.toArray();
                    // localStorage.setItem(sortable.options.group.name, orders.join('|'));
                }
            },
        });
        sortables[i].option('sort', false);
    }
    for(let btn_i = 0; btn_i < btn_sort_item.length; btn_i++){
        let flg_btn = [];
        flg_btn.push(false);
        btn_sort_item[btn_i].addEventListener('click', (e) => {
            let parentRow = e.target.parentNode.parentNode.parentNode.getElementsByClassName('items')[0];
            let btns = parentRow.getElementsByClassName('edit');
            let item_name = parentRow.getElementsByClassName('item_name');
            if(!flg_btn[btn_i]){
                for(let i = 0; i < tbl_items.length; i++){
                    if(tbl_items[i] == parentRow){
                        sortables[i].option('sort', true);
                    }
                }
                for(let i = 0; i < btns.length; i++){
                    btn_displays.push(btns[i].style.display);
                    btns[i].style.display = 'none';
                    item_name[i].classList.remove('col-6');
                    item_name[i].classList.add('col-12');
                }
                btn_sort_item[btn_i].innerHTML = '完了';
                flg_btn[btn_i] = true;
            }
            else{
                for(let i = 0; i < tbl_items.length; i++){
                    if(tbl_items[i] == parentRow){
                        sortables[i].option('sort', false);
                    }
                }
                for(let i = 0; i < btns.length; i++){
                    btns[i].style.display = btn_displays[i];
                    item_name[i].classList.remove('col-12');
                    item_name[i].classList.add('col-6');
                }
                btn_sort_item[btn_i].innerHTML = 'ルールの順番を変更';
                flg_btn[btn_i] = false;
            }
        });
    }
}

export const sort_cat = () => {
    const lib = new Lib_menu();
    const btn_sort = document.getElementById('btn_sort');
    let flg_btn = false;
    let btn_displays = [];
    let tbl_rows_displays = [];
    let btns = document.getElementsByClassName('btn');
    let tbl_rows = document.getElementsByClassName('tbl_row');
    let orders;
    
    let tbls = document.getElementsByClassName('tbls')[0];
    let sortable = Sortable.create(tbls,{
        animation: 110,
        store: {
            set: function (sortable) {
                orders = sortable.toArray();
                // localStorage.setItem(sortable.options.group.name, orders.join('|'));
            }
        },
    });
    sortable.option('sort', false);
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
            sortable.option('sort', true);
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
                lib.ajax('POST', 'https://artful.jp/staging-menu/bin/ajax/update_sort.php', form);
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
                    btn_sort.innerText = 'カテゴリーの順番を変更';
                    btn_sort.classList.remove('done');
                }
            }
            sortable.option('sort', false);
            flg_btn = false;
        }
    });
}