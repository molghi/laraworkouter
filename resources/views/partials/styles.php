<style>
    :root {
        --bg: #000;
        --accent: antiquewhite;
    }

    /* to shut up red non-https warning */
    body > div[style="background: red; color: white; padding: 10px; position: fixed; bottom: 0px; width: 100%; text-align: center; z-index: 1000;"] {
        display: none !important;
    }


    /* thin dark scrollbar */
    /* Chrome, Edge, Safari */
    ::-webkit-scrollbar{width:8px;height:8px}
    ::-webkit-scrollbar-track{background:transparent}
    ::-webkit-scrollbar-thumb{background:rgba(100,100,100,0.6);border-radius:999px;border:2px solid transparent;background-clip:padding-box}
    ::-webkit-scrollbar-thumb:hover{background:rgba(100,100,100,0.8)}
    /* Firefox */
    *{scrollbar-width:thin;scrollbar-color:rgba(100,100,100,0.6) transparent}


    @keyframes blink{0%,49%{opacity:0}50%,100%{opacity:1}}


    .bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        filter: brightness(60%) contrast(140%) saturate(60%) blur(2px);
        /* background: url('../bg-img/Ve9W.gif') 0 0 / cover no-repeat; */
        background: url('../bg-img/snowing-in-the-dusk.gif') 0 0 / cover no-repeat;
        transition: all .5s;
    }

</style>