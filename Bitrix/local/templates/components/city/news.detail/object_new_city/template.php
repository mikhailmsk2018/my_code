<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if($arResult["DETAIL_PICTURE"]['ID'])
	$pic = my_resize($arResult["DETAIL_PICTURE"]['ID'], 350, 210);
elseif($arResult["PREVIEW_PICTURE"]['ID'])
	$pic = my_resize($arResult["PREVIEW_PICTURE"]['ID'], 350, 210);

if(!$arResult['PROPERTIES']['instagram']['VALUE']) $arResult['PROPERTIES']['instagram']['VALUE'] = 'https://www.instagram.com/';
?>
<?

//if( $USER->IsAdmin() ){
//echo '<pre>'; 
//var_dump($arResult['HOUSES']); 
//echo '</pre>';
//} 

?>

<style>
.ikonki{
    align-items: center;   
    justify-items: end;
    align-content: center;
    vertical-align: bottom;
    display: flex;
    margin-left: auto;
    margin-right: auto;
    }
.ikonkiflex{
    display: flex;
    flex-direction: row;    
}    

.firstDescription{ 
   font-size: 23px;
   font-family: 'Arial';
   font-weight: 700;
   text-align: center;
   padding: 1px;
   white-space:normal;
}
.secondDescription{
   font-size: 15px;
   font-family: 'Arial';
   font-weight: 600;
   padding: 1px;
   white-space:normal;
}
.social{
   width: 60px;
   height: auto;
}
.otstup{	
	margin-top: 20px;
}
.otstup2{	
	margin: 25px 0 25px 0;
    
}
.otstup3{	
	margin-left: 35px;
    margin-top: 30px;   
}
.otstup4{	
    margin: 20px 0 10px 0;
    height: 50px;   
}
h1{
   display: flex;
   flex-direction: column;
   border-style: none  none solid none;
   border-bottom-width: 1px;
   border-color: #f51414;
   padding: 10px;
   padding-top: 15px;
   display: table-cell;
}
.descriptionBlock
	{
		display: flex;
	   flex-direction: column;
	   border-style: none solid  none  none;
	   border-bottom-width: 1px;
		border-color: #f51414;	
		padding: 15px;
	   padding-top: 15px;
		display: table-cell;
	}
.svoistva{
   display: flex;
   flex-direction: column;
   border-style: none solid none none;
   border-right-width: 1px;
   border-right-color: #f51414;
   padding: 15px; 
   padding-top: 15px;  
}
.svoistva2{	
		display: flex;
	   flex-direction: column;
	   border-style: none none none  none;
	   border-bottom-width: 1px;
	   border-color: gray;
	   padding: 15px;
	   padding-top: 15px;
	   
	}
@media screen and (max-width: 800px){
.svoistva{
   display: flex;
   flex-direction: column;
   border-style: none none none none;
   border-right-width: 0px;
   border-right-color: #f51414;
   padding: 15px; 
   padding-top: 15px;  
}
}

.img3 a {
    margin-top: 20px;
    padding: 5px;
}

.gallery.gallery-sm .img2 {
     
    margin-left: auto;
    margin-right: auto;
    margin-top: 15px;

}



 .gallery.gallery-sm .item {
    width: 282px;
   
}
.gallery.gallery-sm .img {
    width: 272px;
    height: 190px;
}





@media screen and (max-width: 1380px){
         .gallery.gallery-sm .item {
            width: 282px;
           
        }
        .gallery.gallery-sm .img {
            width: 271px;
            height: 189px;
        }
}

@media screen and (max-width: 1277px){
         .gallery.gallery-sm .item {
            width: 281px;
           
        }
        .gallery.gallery-sm .img {
            width: 272px;
            height: 188px;
        }
}
@media screen and (max-width: 1230px){
         .gallery.gallery-sm .item {
            width: 232px;
           
        }
        .gallery.gallery-sm .img {
            width: 223px;
            height: 153px;
        }
        .ikonkiflex{
            
            flex-direction: row;           
        }
        .ikonki {
            align-items: center;
            justify-items: end;
            align-content: center;
            vertical-align: bottom;
            display: flex;
            margin-left: auto;
            margin-right: auto;
        }
        .img3 a {
             margin-top: 20px; 
             padding: 1px;     
        }
}



@media screen and (max-width: 600px ){
        .ikonkiflex {
            display: inline-block;
            flex-direction: row; 
            width: 100%;
            margin-left: 3%;
            margin-right: 50%;    
        }
        .ikonki {
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }
        .img3 a {
             margin-top: 20px;      
        }
}
@media screen and (max-width: 787px ){
        .ikonkiflex { 
            display: block;
            width: 100%;
            margin-left: 3%;
            margin-right: 50%;    
        }
        .ikonki {
            width: 50%;
            margin-left: auto;
            margin-right: auto;
            padding-left: 10px;
            padding-top: 10px;
        }
        .img3 a {
             padding: 4px;
            display: table-cell;
            margin-right: auto;
            margin-left: auto; 
        }
}




@media screen and (max-width: 1480px)
	.descriptionBlock {
	  	display: flex;
	   flex-direction: column;
	   border-style: none solid  none  none;
	   border-bottom-width: 0px;
	   border-color: #f51414;
	   padding: 10px;
	   padding-top: 15px;
	   display: table-cell;
	}
	.soc{
		display: none;
	}
@media screen and (max-width: 800px)
.svoistva{	
		display: flex;
	   flex-direction: column;
	   border-style: none none solid  none;
	   border-bottom-width: 1px;
	   border-color: gray;
	   padding: 10px;
	   padding-top: 15px;
	   display: table-cell;
	}
.descriptionBlock2
	{
   display: flex;
   flex-direction: column;
   border-style: none none none none;
   border-right-width: 1px;
   border-right-color: gray;
   padding: 10px;
   margin-top: 15px;
   display: table-cell;
	}
@media only screen and (max-width: 780px)	
	.myyy-col .img-responsive{
		display: inline-block;
		margin-top: 25px;
		padding-top: 5px;
	}
.gallery .img {
    display: block;
    width: 50%;
    height: auto;
    background-position: center center;
    background-repeat: no-repeat;
    -webkit-background-size: cover;
    background-size: cover;
    transition: transform .4s;
    }     
@media screen and (max-width: 786px)
.object-list .item {
     display: table;
}   


</style>

<h1><?=$arResult['NAME']?></h1>
			
<div class="object-list">
    <div class="item">
		<div class="cell">

		
		<div class="container">
			<div class="row">
            <div class="col-sm-12 col-md-12">
		           <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                        		<?if(count($arResult['HOUSES'])): ?>               
                                        <?foreach ($arResult['HOUSES'] as $key => $house):?>
                                            <div class="line line-sm object-adress-line otstup">
                                                <img src="<?=SITE_TEMPLATE_PATH?>/images/obj-2.png" alt="" style="height:30px; margin-right:10px; max-width: 50%;" /><span><?=$house?></span>
                                            </div>
                                        <?endforeach?>
                                    <?endif?>
    		              </div>
                          
                   </div>
                   <!-- описание текс -->
	               <div class="row">
                                 <div class="col-sm-12" style="margin-top:20px">
					                   <?=$arResult['DETAIL_TEXT']?>
                                 </div>
                                
                   </div> 
                    
                    
                    <!-- блоки 4 -->
                   <div class="row otstup">          
                            <div class="col-sm-3 myyy-col text-center svoistva otstup2">
    							<span class='firstDescription img-responsive'><?=$arResult['PROPERTIES']['HOMEAREA']['VALUE']?></span>
    							<span class='secondDescription img-responsive' >общая площадь</span>
				            </div>
						 
                            <? if($arResult['PROPERTIES']['AREA']['VALUE'] != ""){?>
				            <div class="col-sm-3 myyy-col text-center svoistva otstup2">  
    							<span class='firstDescription img-responsive'><?=$arResult['PROPERTIES']['AREA']['VALUE']?></span>
    							<span class='secondDescription img-responsive'>полезная площадь</span>
				            </div>
                            <?}?> 
                            <? if($arResult['PROPERTIES']['BEGIN']['VALUE']){ ?>
				            <div class="col-sm-3 myyy-col text-center svoistva otstup2">
    							<span class='firstDescription img-responsive'><?=$arResult['PROPERTIES']['BEGIN']['VALUE']?> год</span>
    							<span class='secondDescription img-responsive'>начало управления</span>
				            </div>
                            <? } ?>
                            <? if($arResult['PROPERTIES']['AGE']['VALUE']){?>
				            <div class="col-sm-3 myyy-col text-center svoistva2 otstup2">
    							<span class='firstDescription img-responsive'><<?=$arResult['PROPERTIES']['AGE']['VALUE'] ?></span>	
    							<span class='secondDescription img-responsive'>возраст здания</span>
				            </div>
                            <?}?>
                            <div class="col-sm-3"></div>
                   </div>
                   
                   <!-- слайдер галерея -->
                   <div class="row ikonkiflex">
                                <div class="col-sm-9 ">				
				                    	<div class="gallery gallery-sm">
                							<?if(count($arResult['PROPERTIES']['PHOTOS']['VALUE'])):?>
                								<?foreach($arResult['PROPERTIES']['PHOTOS']['VALUE'] as $key => $photo):
                									$preview = my_resize($photo, 300, 300);
                									$img = my_resize_watemark($photo, 1200, 960);?>
                										<div class="item img2">
                											<a class="img"  href="<?=$img['src']?>" title="<?=$arResult['NAME']?>" data-lightbox="gallery" style="background-image:url('<?=$preview['src']?>');"></a>
                										</div>
                								<?endforeach?>
                							<?endif?>
					                   </div>
                                      
			                     </div>
                                 
                                 
                                 <!-- иконки соцсетей -->
                                 <div class="col-sm-3 ikonki">
                                        <div class="col-sm-12 img3">
                                            <a class="lfb-link" href="<?=$arResult['PROPERTIES']['facebook']['VALUE']?>" target="_blank"><img class="social" src="/local/templates/city24/components/bitrix/news.detail/object_new_city/img/facebook.png" alt="" /></a>
                            				<a class="lig-link" href="<?=$arResult['PROPERTIES']['instagram']['VALUE']?>" target="_blank"><img class="social" src="/local/templates/city24/components/bitrix/news.detail/object_new_city/img/instagram.png" alt="" /></a>
                		                </div>
                               		      
                                  </div>
                                  
                             
                   </div><!-- слайдер галерея  Закрываем-->
                   
                              
                   
                   
		</div><!-- COL закрываем -->
        
                        </div><!-- внешний Row -->                 
                </div></div>
                
        </div>
            </div>		
            </div>
            
   		
										
		</div>							
			
		</div>					
    	
