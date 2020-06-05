<?php require 'views/YonPanel/header.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          

          <div class="row ">
      <div class="col-xl-12 col-lg-12 col-md-12 mb-12 "> 
      
     
       
    
      
      <?php 
	  
	  
	  			if (isset($veri["bilgi"])) :
				
				
				echo $veri["bilgi"];
				
				
				endif;
		  
		  
	  if (isset($veri["YoneticiGuncelle"])) :

	
	  ?>
      
       <!-- BAŞLIK -->
      
       <div class="row text-left border-bottom-mvc mb-2">  
       
        	 <div class="col-xl-12 col-md-12 mb-12 border-left-mvc text-left p-2 mb-2"><h1 class="h3 mb-0 text-gray-800"> <i class="fas fa-th basliktext"></i> YÖNETİCİ GÜNCELLE </h1></div>
              
 
          </div>
          <!-- BAŞLIK --> 	
      
         
            <!--  FORMUN İSKELETİ-->
          
    <div class="col-xl-12 col-md-12  text-center" id="GuncelleformuAna"> 
      
       <div class="row text-center">  
       
        	<div class="col-xl-4 col-md-6 mx-auto">
             
             <div class="row bg-gradient-beyazimsi">
             
             	<div class="col-lg-12 col-md-12 col-sm-12 bg-gradient-mvc pt-2 basliktext2"><h3>Yönetici Güncelle</h3></div>
							
                <div class="col-lg-12 col-md-12 col-sm-12 formeleman">Yönetici Adı</div>
                <div class="col-lg-12 col-md-12 col-sm-12 formeleman nocizgi">
                    	 <?php 	Form::Olustur("1",array(
					 "action" => URL."/panel/yonguncelle/son",
					 "method" => "POST"				
					 ));  
                    			Form::Olustur("2",array("type"=>"yonad","class"=>"form-control","name"=>"yonadi","value"=>$veri["YoneticiGuncelle"][0]["ad"]));?>  
                 	</div> <!-- Yönetici Adı-->

				<div class="col-lg-12 col-md-12 col-sm-12 formeleman">Genel Yetki</div>
                <div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                    	 <?php 	Form::OlusturSelect("1",array("name"=>"yetki","class"=>"form-control m-2"));
					
								$yetkiler=array(
								1 => "Tam Yetki",
								2 => "Ürün Yetki",
								3 => "Üye Yetki"
								);
					
								foreach ($yetkiler as $key => $deger) :
					
									if ($veri["YoneticiGuncelle"][0]["yetki"]==$key) :
									
									Form::OlusturOption(array("value"=>$key),"selected",$deger);
					
									else:
					
									Form::OlusturOption(array("value"=>$key),false,$deger);
					
									endif;
					
								endforeach;
					  
					  			Form::OlusturSelect("2",null);?>  
                 </div> <!-- Genel Yetki-->
											
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Sipariş yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1"> 	
 	 					<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"siparisYonetim"),false,$veri["YoneticiGuncelle"][0]["siparisYonetim"]==1 ? "checked": NULL);?>            
                 	</div>
				 </div>
                </div> <!-- Sipariş Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Kategori Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"kategoriYonetim"),false,$veri["YoneticiGuncelle"][0]["kategoriYonetim"]==1 ? "checked": NULL);?>
					</div>
				 </div>
                </div> <!-- Kategori Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Üye Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"uyeYonetim"),false,$veri["YoneticiGuncelle"][0]["uyeYonetim"]==1 ? "checked": NULL);?>
					</div>
				 </div>
                </div> <!-- Üye Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Ürün Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"urunYonetim"),false,$veri["YoneticiGuncelle"][0]["urunYonetim"]==1 ? "checked": NULL);?>
					</div>
				 </div>
                </div> <!-- Ürün Yönetimi-->
						
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Muhasebe Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"muhasebeYonetim"),false,$veri["YoneticiGuncelle"][0]["muhasebeYonetim"]==1 ? "checked": NULL);?>
					</div>
				 </div>
                </div> <!-- Muhasebe Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Yönetici Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"yoneticiYonetim"),false,$veri["YoneticiGuncelle"][0]["yoneticiYonetim"]==1 ? "checked": NULL);?>
					</div>
				 </div>
                </div> <!-- Yönetici Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Bülten Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"bultenYonetim"),false,$veri["YoneticiGuncelle"][0]["bultenYonetim"]==1 ? "checked": NULL);?>
					</div>
				 </div>
                </div> <!-- Bülten Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Sistem Ayar</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"sistemayarYonetim"),false,$veri["YoneticiGuncelle"][0]["sistemayarYonetim"]==1 ? "checked": NULL);?>
					</div>
				 </div>
                </div> <!-- Sistem Ayar-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Sistem Bakım</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"sistembakimYonetim"),false,$veri["YoneticiGuncelle"][0]["sistembakimYonetim"]==1 ? "checked": NULL);?>
					</div>
				 </div>
                </div> <!-- Sistem Bakım-->
				 
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 text-right pt-1"><span id="sec" class="text-success">Tümünü Seç</span></div>
					<div class="col-lg-6 col-md-6 col-sm-6 text-left pt-1"><span id="kaldir"class="text-danger">Tümünü Kaldır</span></div>
				 </div>
                </div> <!-- Tümünü Seç / Tümünü Kaldır-->
         
              	<div class="col-lg-12 col-md-12 col-sm-12 formeleman nocizgi">
					<?php 	Form::Olustur("2",array("type"=>"hidden","name"=>"yonid","value"=>$veri["YoneticiGuncelle"][0]["id"]));
							Form::Olustur("2",array("type"=>"submit","value"=>"YÖNETİCİ GÜNCELLE","class"=>"btn btn-success"));		
							Form::Olustur("kapat");?>
				</div> <!-- Yönetici Güncelle Butonu-->
            
             </div>
         
            </div>
       
      	</div>
				
     </div>
         
           <!--  FORMUN İSKELETİ-->
      
      
      <?php 
	  
	
	  	  
	  endif; // YÖNETİCİ GÜNCELLEME
	  
	  //*****************************************************
				
				
	  if (isset($veri["yoneticiekle"])) :

	
	  ?>
      
       <!-- BAŞLIK -->
      
       <div class="row text-left border-bottom-mvc mb-2">  
       
        	 <div class="col-xl-12 col-md-12 mb-12 border-left-mvc text-left p-2 mb-2"><h1 class="h3 mb-0 text-gray-800"> <i class="fas fa-th basliktext"></i> YÖNETİCİ EKLE </h1></div>
              
 
          </div>
          <!-- BAŞLIK --> 	
      
         
            <!--  FORMUN İSKELETİ-->
          
    <div class="col-xl-12 col-md-12  text-center" id="EklemeformuAna"> 
      
       <div class="row text-center">  
       
        	<div class="col-xl-4 col-md-6 mx-auto">
             
             <div class="row bg-gradient-beyazimsi">
             
             	<div class="col-lg-12 col-md-12 col-sm-12 bg-gradient-mvc pt-2 basliktext2"><h3>Yeni Yönetici Ekle</h3></div>
							
                <div class="col-lg-12 col-md-12 col-sm-12 formeleman">Yönetici Adı</div>
                <div class="col-lg-12 col-md-12 col-sm-12 formeleman nocizgi">
                    	 <?php 	Form::Olustur("1",array(
					 "action" => URL."/panel/yonekle/son",
					 "method" => "POST"				
					 ));  
                    			Form::Olustur("2",array("type"=>"yonad","class"=>"form-control","name"=>"yonadi"));?>  
                 	</div> <!-- Yönetici Adı-->

                <div class="col-lg-12 col-md-12 col-sm-12 formeleman">Şifre</div>
                <div class="col-lg-12 col-md-12 col-sm-12 formeleman nocizgi">
                    	 <?php Form::Olustur("2",array("type"=>"password","class"=>"form-control","name"=>"sif1"));?>  
                  </div> <!-- Şifre-->
                                 
                <div class="col-lg-12 col-md-12 col-sm-12 formeleman">Şifre (Tekrar)</div>
                <div class="col-lg-12 col-md-12 col-sm-12 formeleman nocizgi">
                    	 <?php Form::Olustur("2",array("type"=>"password","class"=>"form-control","name"=>"sif2"));?>  
                  </div> <!-- Şifre Tekrar-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman">Genel Yetki</div>
                <div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                    	 <?php 	Form::OlusturSelect("1",array("name"=>"yetki","class"=>"form-control m-2"));
					  
		  						Form::OlusturOption(array("value"=>1),false,"Tam Yetki");
					  			Form::OlusturOption(array("value"=>2),false,"Ürün Yetki");
					  			Form::OlusturOption(array("value"=>3),false,"Üye Yetki");					  				
 
					  			Form::OlusturSelect("2",null);?>  
                 </div> <!-- Genel Yetki-->
											
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Sipariş yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1"> 	
 	 					<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"siparisYonetim"));?>            
                 	</div>
				 </div>
                </div> <!-- Sipariş Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Kategori Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"kategoriYonetim"));?>
					</div>
				 </div>
                </div> <!-- Kategori Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Üye Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"uyeYonetim"));?>
					</div>
				 </div>
                </div> <!-- Üye Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Ürün Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"urunYonetim"));?>
					</div>
				 </div>
                </div> <!-- Ürün Yönetimi-->
						
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Muhasebe Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"muhasebeYonetim"));?>
					</div>
				 </div>
                </div> <!-- Muhasebe Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Yönetici Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"yoneticiYonetim"));?>
					</div>
				 </div>
                </div> <!-- Yönetici Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Bülten Yönetimi</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"bultenYonetim"));?>
					</div>
				 </div>
                </div> <!-- Bülten Yönetimi-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Sistem Ayar</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"sistemayarYonetim"));?>
					</div>
				 </div>
                </div> <!-- Sistem Ayar-->
							
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 text-right">Sistem Bakım</div>
					<div class="col-lg-5 col-md-5 col-sm-5 text-left pt-1">
						<?php Form::Olustur("2",array("type"=>"checkbox","name"=>"sistembakimYonetim"));?>
					</div>
				 </div>
                </div> <!-- Sistem Bakım-->
				 
				<div class="col-lg-12 col-md-12 col-sm-12 formeleman cizgi">
                 <div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 text-right pt-1"><span id="sec" class="text-success">Tümünü Seç</span></div>
					<div class="col-lg-6 col-md-6 col-sm-6 text-left pt-1"><span id="kaldir"class="text-danger">Tümünü Kaldır</span></div>
				 </div>
                </div> <!-- Tümünü Seç / Tümünü Kaldır-->
         
              	<div class="col-lg-12 col-md-12 col-sm-12 formeleman nocizgi">
					<?php 	Form::Olustur("2",array("type"=>"submit","value"=>"YÖNETİCİ EKLE","class"=>"btn btn-success"));
							Form::Olustur("kapat");?>
				</div> <!-- Yönetici Ekle Butonu-->
            
             </div>
         
            </div>
       
      	</div>
				
     </div>
         
           <!--  FORMUN İSKELETİ-->
      
      
      <?php 
	  
	
	  	  
	  endif; // YÖNETİCİ EKLEME
	  
	  //*****************************************************			
				
				
				

	 
	 // YÖNETİCİLER GELİYOR
	  if (isset($veri["data"])) :
	  
	
	   ?>
      

      
      <!-- BAŞLIK -->
      
       <div class="row text-left border-bottom-mvc mb-2">  
       
        	 <div class="col-lg-8 col-xl-8 col-md-12 mb-12 border-left-mvc text-left p-2 mb-2"><h1 class="h3 mb-0 text-gray-800"> <i class="fas fa-th basliktext"></i> YÖNETİCİLER  </h1></div>
              
 

             
        
     <div class="col-lg- col-xl-4 col-md-12 mb-12 text-right"> 
                
        	<div class="col-xl-12 text-right">  <a href="<?php echo URL."/panel/yonekle/ilk";?>" class="btn btn-sm btn-success ">Yeni Yönetici Ekle</a>  </div>
     
    
     </div>    
       
          </div>
          <!-- BAŞLIK --> 	
          
          
               <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12  mx-auto  text-center"> 
                
      	<!-- SİPARİŞİN İSKELETİ BAŞLIYOR -->
        		 <div class="row arkaplan p-1 mt-2 pb-0 text-center mx-auto">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 border-right p-2 pt-3 geneltext">
                    <span><h5 class="text-danger">Kayıtlı Yönetici Sayısı : <?php echo count($veri["data"]); ?></h5></span> 
                    </div> 
                 
                  
                 
                 	<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 border-right p-2 pt-3 geneltext bg-gradient-mvc">
                    <span>Yönetici Yetki</span> 
                    </div>
                    
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 border-right p-2 pt-3 geneltext bg-gradient-mvc">
                    <span >Yönetici Adı</span> 
                    </div>
                    
              
                    
                     <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 p-2 pt-3   geneltext bg-gradient-mvc">
                <span >İşlemler</span> 
                    </div>
                    
             
                    
                       <?php   foreach ($veri["data"] as $value) : ?>
           
                     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-2 p-0">
                     
                                      
                        <?php 
						
		
							echo '<div class="row border border-light">
							     
<div class="col-lg-5 col-xl-5 col-md-5 col-sm-5 text-dark kalinyap p-2 mt-2">';
						 
						 switch ($value["yetki"]) :
						 
						 case "1": echo'<span class="text-success">Tam Yetki</span>'; break;
						 
						 case "2": echo'<span class="text-danger">Ürün Yetki</span>'; break;
						 
						 case "3": echo'<span class="text-primary">Üye Yetki</span>'; break;
						 
						 endswitch;
						 
echo'</div>
<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 text-dark kalinyap p-2 mt-2">'.$value["ad"].'</div>
<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 text-dark kalinyap p-2 text-center">';  
	if(Session::get("Adminid") !=$value["id"]):

	echo '
	
	<a href="'.URL.'/panel/yonguncelle/ilk/'.$value["id"].'" class="fas fa-sync  guncelbuton mr-2 "></a>';?>
						 
	<a onclick="silmedenSor('<?php echo URL."/panel/yonSil/".$value["id"];?>'); return false"  class="fas fa-times mt-1 p-1 text-danger  alertSilme"></a>
						 
	<?php
						 
	else:
						
	echo '
	<a href="'.URL.'/panel/yonguncelle/ilk/'.$value["id"].'" class="fas fa-sync mr-2 guncelbuton "></a>
 	<a onclick="#" class="fas fa-times mt-1 p-1 alertSilme"></a>';
	endif;
 echo' </div>
 </div>  
  </div>';	
					
					
	  					endforeach;
						
						
						 ?>
                 
                  
                 
                 
                 </div>
        
      	<!-- SİPARİŞİN İSKELETİ BİTİYOR -->
        </div>
        <?php endif; ?>  
          
  </div> 
  
      
        </div>  
<!-- /.row bitiyor -->

        </div>
        <!-- /.container-fluid -->

     

     
     
     <?php require 'views/YonPanel/footer.php'; ?>