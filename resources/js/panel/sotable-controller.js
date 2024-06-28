import Sortable from "sortablejs";
import axios from "axios";
document.addEventListener('DOMContentLoaded', function() {
    let sortableList = document.querySelector('#sort-control > .ol-sortable');

    if (sortableList == null){

        return;
    }
    let sortable = new Sortable(sortableList, {
        group: 'nested',
        animation: 150,
        fallbackOnBody: true,
        swapThreshold: 0.65,
        onEnd: function (evt) {
            serializeList();
        }
    });

    // Initialize nested sortables
    let nestedSortables = document.querySelectorAll('.ol-sortable');
    for (let i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onEnd: function (evt) {
                serializeList();
            }
        });
    }

    function serializeList() {
        let serialized = [];
        serializeNode(sortableList, serialized);
        // console.log(JSON.stringify(serialized, null, 2));
        document.querySelector('#sort-data').value = JSON.stringify(serialized);
    }

    function serializeNode(ol, serialized, parentId = null) {
        let children = ol.children;
        for (let i = 0; i < children.length; i++) {
            let li = children[i];
            let id = li.getAttribute('data-id');
            let item = { id: id, children: [] };
            if (parentId) {
                item.parentId = parentId;
            }
            serialized.push(item);

            let nestedOl = li.querySelector(':scope > ol');
            if (nestedOl) {
                serializeNode(nestedOl, serialized, id);
            }
        }
    }

    // Initial serialization
    serializeList();

    document.querySelector('#save-sort')?.addEventListener('click',async function () {
        const url  = this.getAttribute('data-link');
        const data = JSON.parse(document.querySelector('#sort-data').value);
        try {
            let resp = await  axios.post(url,{items: data});
            if (resp.data.OK) {
                $toast.info(resp.data.message);
            }else{

                $toast.error(resp.data.error);
            }
        } catch(e) {
            $toast.error(e.message);
        }

    });
});
