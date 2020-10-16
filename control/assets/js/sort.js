import Lib_menu from '../../../lib/js/lib_menu.js';

export const sort_item = () => {
    const lib = new Lib_menu();
    let flg_sort = false;
    let btn_sort_item = document.getElementsByClassName('btn_sort_item');
    let btn_text = btn_sort_item[0].innerText;
    let flgs_btn = [];
    let sortables = [];
    let orders = [];
    for(let i = 0; i < btn_sort_item.length; i++){
        flgs_btn.push(false);
        let items = btn_sort_item[i].closest('div.tbl_item').getElementsByClassName('items')[0];
        sortables[i] = Sortable.create(items,{
            animation: 110,
            store: {
                set: function (sortable) {
                    orders[i] = sortable.toArray();
                    console.log(orders);
                    flg_sort = true;
                    // localStorage.setItem(sortable.options.group.name, orders.join('|'));
                }
            }
        });
        sortables[i].option('disabled', true);
        btn_sort_item[i].addEventListener('click', (e) => {
            if(!flgs_btn[i]){
                e.target.innerText = '完了';
                e.target.classList.add('btn');
                e.target.classList.add('done');
                sortables[i].option('disabled', false);
                flgs_btn[i] = true;
            }
            else{
                e.target.innerText = btn_text;
                e.target.classList.remove('btn');
                e.target.classList.remove('done');
                sortables[i].option('disabled', true);
                flgs_btn[i] = false;
                let tbl_row = items.getElementsByClassName('tbl_row');
                let tbl_item = items.closest('div.tbl_item');
                if(flg_sort){
                    for(let row_i = 0; row_i < tbl_row.length; row_i++){
                        let data_id = tbl_row[row_i].getAttribute('data-id');
                        let data_tbl = tbl_row[row_i].getAttribute('data-tbl');
                        let item_id = tbl_row[row_i].id;
                        let tbl_item_id = parseInt(tbl_item.getAttribute('data-id')) - 1;
                        let _order = Object.keys(orders[tbl_item_id]).filter(function(k) { return orders[tbl_item_id][k] == data_id})[0];
                        let order = parseInt(_order) + 1;
                        let form = new FormData();
                        form.append('tbl', data_tbl);
                        form.append('item_id', item_id);
                        form.append('order', order);
                        lib.ajax('POST', 'https://artful.jp/staging-menu/bin/ajax/update_sort.php', form);
                    }
                    flg_sort = false;
                }
            }
        });
    }
}

export const sort_cat = () => {
    const lib = new Lib_menu();
    const btn_sort = document.getElementById('btn_sort_cat');
    let flg_btn = false;
    let flg_sort = false;
    let btn_displays = [];
    let tbl_rows_displays = [];
    let btns = document.getElementsByClassName('btn');
    let wrap_btn_add = document.getElementById('wrap_btn_add');
    let tbl_rows = document.getElementsByClassName('tbl_row');
    let orders;
    
    let tbls = document.getElementsByClassName('tbls')[0];
    let sortable = Sortable.create(tbls,{
        animation: 110,
        store: {
            set: function (sortable) {
                orders = sortable.toArray();
                flg_sort = true;
                // localStorage.setItem(sortable.options.group.name, orders.join('|'));
            }
        },
    });
    sortable.option('disabled', true);
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
            wrap_btn_add.style.display = 'none';
            sortable.option('disabled', false);
            flg_btn = true;
        }
        else{
            let tbl_items = document.getElementsByClassName('tbl_item');
            if(flg_sort){
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
                flg_sort = false;
            }
            for(let tr_i = 0; tr_i < tbl_rows.length; tr_i++){
                tbl_rows_displays.push(tbl_rows[tr_i].style.display);
                tbl_rows[tr_i].style.display = tbl_rows_displays[tr_i];
            }
            wrap_btn_add.style.display = 'block';
            for(let b_i = 0; b_i < btns.length; b_i++){
                if(btns[b_i] != btn_sort){
                    btns[b_i].style.display = btn_displays[b_i];
                }
                else{
                    btn_sort.innerText = 'カテゴリーの順番を変更';
                    btn_sort.classList.remove('done');
                }
            }
            sortable.option('disabled', true);
            flg_btn = false;
        }
    });
}
