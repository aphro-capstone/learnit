<style>
    video{
        box-shadow: -1px 26px 23px #7997e17d;
        z-index:1000;
        position:relative;
        transition: ease all 0.5s;
    }
    .overlay-focus{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 0;
        background: #000000c4;
        z-index: 999;
        transition:ease all 0.5s;
    }

    body.focus-mode .overlay-focus{
        height:100%;
    }
    body.focus-mode video{
        box-shadow:none;
        border-radius: 10px;
    }
 
</style>



<div class="container">
    <div class="overlay-focus"></div>
    <div class="d-table mb-2">
        <button class="btn btn-primary btn-xs focus-mode pull-right"> <i class="fa fa eyes"></i> Focus Mode/ Less distruction </span>
    </div>
    <video preload="auto" controls="controls" autoplay class="full-width">
        <source src="<?=site_url()?>assets/multimedia/<?= $video['m_path'];?>" type="video/mp4">\
        <source src="media/why-autologel.webm" type="video/webm">\
    </video> 
     
</div>



<script>



    jQuery(function($){
        $('.focus-mode').on('click',function(){
            $('body').addClass('focus-mode');
        });

        $('.overlay-focus').on('click',function(){
            $('body').removeClass('focus-mode');
        });
    });

</script>