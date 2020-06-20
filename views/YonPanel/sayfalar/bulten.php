<?php require 'views/YonPanel/header.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	
	<!-- Page Heading -->
    <div class="row">
    	<div class="col-xl-12 col-md-12 mb-12 text-center"> 
      	<?php	if (isset($veri["bilgi"])) :
					echo $veri["bilgi"];
				endif;
	  			if (isset($veri["data"])) : ?>
			
			<!-- BAŞLIK -->
      		<div class="row text-left border-bottom-mvc mb-2">  
       			<div class="col-lg-2 col-xl-2 col-md-12 mb-12 border-left-mvc text-left p-2 mb-2"><h1 class="h3 mb-0 text-gray-800"> <i class="fas fa-th basliktext"></i> BÜLTEN</h1></div>
            	<div class="col-lg-9 col-xl-9 col-md-12 mb-12 text-right">
     				<div class="row">
						<div class="col-xl-2 ">
    					<?php	Form::Olustur("1",array(
								"action" => URL."/panel/tarihegoregetir",
								"method" => "POST"								
								));  
						 		Form::Olustur("2",array("type"=>"date","name"=>"tar1","class"=>"form-control")); ?>
    					</div>
    					<div class="col-xl-2 ">
    					<?php	Form::Olustur("2",array("type"=>"date","name"=>"tar2","class"=>"form-control")); ?>
    					</div>
    					<div class="col-xl-2 ">
    					<?php	Form::Olustur("2",array("type"=>"submit","value"=>"GETİR","class"=>"btn btn-sm btn-mvc btn-block mt-1"));		 
			 					Form::Olustur("kapat"); ?>
     					</div>
        				<div class="col-xl-4">
         	  			<?php	Form::Olustur("1",array(
								"action" => URL."/panel/mailarama",
								"method" => "POST"				
								));  
						 		Form::Olustur("2",array("type"=>"text","name"=>"arama","class"=>"form-control","placeholder"=>"Mail Adresi Yazın")); ?>		
						</div>
        				<div class="col-xl-2">
                   		<?php	Form::Olustur("2",array("type"=>"submit","value"=>"ARA","class"=>"btn btn-sm btn-mvc btn-block mt-1"));		
			 					Form::Olustur("kapat"); ?>
             			</div>
        			</div>
     			</div>  
		     	
       		</div>
          	<!-- BAŞLIK -->
                
      	<!-- İSKELET BAŞLIYOR -->
        		 <div class="row arkaplan p-1 mt-2 pb-0">
                 	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 border-right p-2 pt-3 geneltext bg-gradient-mvc">
						<div class="row">
							<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 text-center pt-2">
						<?php 
						if (isset($veri["tariharama"])):
							echo '<span>'.$veri["tarih1"].' - '.$veri["tarih2"].' Tarihleri arasındaki mailler - Toplam Mail Sayısı : </span>';
							echo $veri["toplamveri"];
						elseif(isset($veri["arama"])):
							echo '<span>Tüm '.$veri["arama"].' mailleri -  Toplam Mail Sayısı :</span>';
							echo $veri["toplamveri"];
						else:
							echo '<span>Bütün mailler -  Toplam Mail Sayısı : </span>';
							echo $veri["toplamveri"];
						endif; ?>
							</div>
							<div class="col-lg-4 col-xl-4 col-md-12 mb-12 text-right">
								<input type="button" id="tumunusecbtn" class="btn btn-secondary btn-sm" value="SEÇ">	
								<input type="button" id="tumunukaldirbtn" class="btn btn-secondary btn-sm" value="KALDIR">
								<input type="button" id="toplusilbtn" class="btn btn-danger btn-sm" value="TOPLU SİL">	
							</div>
							<div class="col-lg-1 col-xl-1 col-md-12 mb-12 text-left">
								<div class="dropdown shop">
								<a class="btn btn-sm btn-mvc dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-hashpopup="true" aria-expanded="false">Dosya</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="<?php echo URL; ?>/panel/bultenExcelAl"><i class="fas fa-file-export text-dark "></i> Excel</a>
										<a class="dropdown-item" href="<?php echo URL; ?>/panel/bultenTxtAl"><i class="fas fa-file-alt text-dark "></i> Txt</a>   
									</div>
								</div>
							</div>
						</div>
                    </div>
					<!-- ÜRÜNLER -->
                    <?php foreach ($veri["data"] as $value) : 
           					echo '
							<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 mt-2">
                            	<div class="row m-1 mailcerceve">
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 p-1 pt-2">';
					 				Form::Olustur("2",array("type"=>"checkbox","value"=>$value["id"],"name"=>"silme"));
					 				echo'
					 				</div>
                                	<div class="col-xl-8 col-lg-8 col-md-8 col-sm-4 p-1">
                                  		'.$value["mailadres"].'
                                  	</div>
                                  	<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                              	  		<a href="'.URL.'/panel/mailSil/'.$value["id"].'" class="fas fa-times silbuton"></a>
                                  	</div>
								</div>
                        	</div>';
					 	  endforeach; ?>                 
                 </div>        
      	<!-- İSKELET BİTİYOR -->
        
        <?php	if(isset($veri["arama"])):
					$link="/panel/mailarama/".$veri["arama"]."/";
		  		elseif(isset($veri["tariharama"])):
		  			$link="/panel/tarihegoregetir/".$veri["tarih1"]."/".$veri["tarih2"]."/";
				else:
					$link="/panel/bulten/";
		  		endif;
				Pagination::numaralar($veri["toplamsayfa"],$link);	 
		  endif; ?>  
  		</div> 
    </div>  
	<!-- /.row bitiyor -->
	
</div>
<!-- /.container-fluid -->
<?php require 'views/YonPanel/footer.php'; ?>