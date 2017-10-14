const state = JSON.parse((document.head.querySelector('script[id="mainData"]')).innerHTML.replace(/^\s+|\s+$/g,''));

    //JSON.parse((document.head.querySelector('script[id="mainData"]')).innerHTML.replace(/^\s+|\s+$/g,''))



export default {
    state,
}
