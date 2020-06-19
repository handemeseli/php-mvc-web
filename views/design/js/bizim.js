
$(document).ready(function(e) {
	
	
	$('#anaekranselect').attr("disabled",false);
	$('#cocukekranselect').attr("disabled",true);
	$('#katidekranselect').attr("disabled",true);
				
	$('#anaekranselect').on('change',function(){
		
		var secilendeger= $(this).val();
		
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/selectkontrol",{"kriter":"anaekrancocukgetir","anaid":secilendeger},function(cevap) {
			$('#cocukekranselect').attr("disabled",false);
			$('#cocukekranselect').html(cevap);
			
		});
		$('#katidekranselect').attr("disabled",true).html('<option value=0>Seçiniz</option>');
	});
	
	$('#cocukekranselect').on('change',function(){
		$('#katidekranselect').attr("disabled",false);
		var secilendeger= $(this).val();
		
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/selectkontrol",{"kriter":"anaekranaltgetir","cocukid":secilendeger},function(cevap) {
			$('#katidekranselect').html(cevap);
		});
		
	});
	
	/* ÜRÜN GÜNCELLEME EKRANI */
	$('#sifirla').on('click',function(){ 
	$('#anaselect').attr("disabled",false);
	$('#cocukselect').attr("disabled",true).html('<option value=0>Seçiniz</option>');
	$('#altselect').attr("disabled",true).html('<option value=0>Seçiniz</option>');
		
	});
		
	$('#anaselect').on('change',function(){
		$('#cocukselect').attr("disabled",false).html('<option value=0>Seçiniz</option>');
		var secilendeger= $(this).val();
		
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/selectkontrol",{"kriter":"cocukgetir","anaid":secilendeger},function(cevap) {
			$('#cocukselect').html(cevap);
			
		});
		$('#altselect').attr("disabled",true).html('<option value=0>Seçiniz</option>');
	});
	
	$('#cocukselect').on('change',function(){
		$('#altselect').attr("disabled",false).html('<option value=0>Seçiniz</option>');
		var secilendeger= $(this).val();
		
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/selectkontrol",{"kriter":"altgetir","cocukid":secilendeger},function(cevap) {
			$('#altselect').html(cevap);
		});
		
	});/* ÜRÜN GÜNCELLEME EKRANI */

	$('#sec').click(function() {
		$('#EklemeformuAna input[type="checkbox"]').attr("checked",true);
		$('#GuncelleformuAna input[type="checkbox"]').attr("checked",true);
	});
	
	$('#kaldir').click(function() {
		$('#EklemeformuAna input[type="checkbox"]').attr("checked",false);
		$('#GuncelleformuAna input[type="checkbox"]').attr("checked",false);
	});
	
	$('#detaygoster #adres').click(function() {
		
		var sipno=$(this).attr('data-value');
		var adresid=$(this).attr('data-value2');
		
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/teslimatgetir",{"sipno":sipno,"adresid":adresid},function(cevap) {
			$(".modal-body").html(cevap);
			$("#exampleModalLongTitle").html("Teslimat Adresi ve Kişisel Bilgiler");
	
		});
	});
		
	$('#detaygoster #siparis').click(function() {
		
		var sipno=$(this).attr('data-value');
		var adresid=$(this).attr('data-value2');
		
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/siparisgetir",{"sipno":sipno,"adresid":adresid},function(cevap) {
			$(".modal-body").html(cevap);
			$("#exampleModalLongTitle").html("SİPARİŞ ÖZETİ");
	
		
	});
		
	});
	
	jQuery.fn.extend({
		printElem: function() {
			var cloned = this.clone();
		var printSection = $('#printSection');
		if (printSection.length == 0) {
			printSection = $('<div id="printSection"></div>')
			$('body').append(printSection);
		}
		printSection.append(cloned);
		var toggleBody = $('body *:visible');
		toggleBody.hide();
		$('#printSection, #printSection *').show();
		window.print();
		printSection.remove();
		toggleBody.show();
		}
	});

	$(document).ready(function(){
		$(document).on('click', '#btnPrint', function(){
		$('#adres').printElem();
	  });
	});

	$("#aramakutusu").attr("placeholder","Sipariş numarası");	
	
	$("#aramaselect").on('change', function(e) {
		
		var secilenial = $(this);
		var valueninDegeri=secilenial.val();		
		if (valueninDegeri=="sipno") {
		$("#aramakutusu").val("");	
		$("#aramakutusu").attr("placeholder","Sipariş numarası yazın");	
		}
		if (valueninDegeri=="uyebilgi") {
		$("#aramakutusu").val("");	
		$("#aramakutusu").attr("placeholder","Üye Bilgilerin herhangi biri");		
		}
		
		
	});

	$("#SepetDurum").load("http://localhost/PROJELER/mvcproje/GenelGorev/SepetKontrol");
	
	$("#Sonuc").hide();
	
	$("#FormAnasi").hide();
	
	
    $("#yorumEkle").click(function(e) {
		 $("#FormAnasi").slideToggle();	
        
    });
	
	
	$("#yorumGonder").click(function() {
		
		$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/YorumFormKontrol',
			data:$('#yorumForm').serialize(),
			success: function(donen_veri){
				$('#yorumForm').trigger("reset");
				$('#FormSonuc').html(donen_veri);
				
				if ($('#ok').html()=="Yorumunuz kayıt edildi. Onaylandıktan sonra yayınlanacaktır") {
					$("#FormAnasi").fadeOut();
					
					
				}
				
			
				
			},
		});
			
		
        
    });
	
	
	$("[type='number']").keypress(function (evt) {
		evt.preventDefault();
		
		
	});
	
	
	$("#bultenBtn").click(function() {
		
		
	$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/BultenKayit',
			data:$('#bultenForm').serialize(),
			success: function(donen_veri){
				$('#bultenForm').trigger("reset");
				$('#Bulten').html(donen_veri);
				
				if ($('#bultenok').html()=="Bultene Başarılı bir şekilde kayıt oldunuz. Teşekkür ederiz") {
				
					
					
				}
				
			
				
			},
		});
			
		
        
    });

	
	$("#İletisimbtn").click(function() {
		//$('#iletisimForm').fadeOut();
		
		
//$('#FormSonuc').html("Merhaba");
		
		
	$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/iletisim',
			data:$('#iletisimForm').serialize(),
			success: function(donen_veri){
				$('#iletisimForm').trigger("reset");
			$('#FormSonuc').html(donen_veri);
				
					if ($('#formok').html()=="Mesajınız Alındı. En kısa sürede Dönüş yapılacaktır. Teşekkür ederiz") {
						
				$('#iletisimForm').fadeOut();
				$('#FormSonuc').html(donen_veri);
					
					
				}
				
				
							
			
				
			},
		});
			
		
        
    });

	
		$("#SepetBtn").click(function() {

		
	$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/SepeteEkle',
			data:$('#SepeteForm').serialize(),
			success: function(donen_veri){
				$('#SepeteForm').trigger("reset");
				
				
				$("html,body").animate({scrollTop : 0} , "slow");
				
		$("#SepetDurum").load("http://localhost/PROJELER/mvcproje/GenelGorev/SepetKontrol");					
		$('#Mevcut').html('<div class="alert alert-success text-center">SEPETE EKLENDİ</div>');
				
					
							
			
				
			},
		});
			
		
        
    });

	$('#GuncelForm input[type="button"]').click(function() {
		
		var id=$(this).attr('data-value');
		
		
		var adet=$('#GuncelForm input[name="adet'+id+'"]').val();
		
		
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/UrunGuncelle",{"urunid":id,"adet":adet},function() {
			
		window.location.reload();
		
	});	
		
		
		
	});
	
	//--------------------------------------------------------------------------

	$('#GuncelButonlarinanasi input[type="button"]').click(function() {
		
		var id=$(this).attr('data-value');
		
		
		var textArea=$("<textarea id='"+id+"' name='yorum' style='width:100% height:200px' />");
		
		
		textArea.val($(".sp"+id).html());
		$(".sp"+id).parent().append(textArea);
		$(".sp"+id).remove();
		input.focus();
		
		
	
		
		
	});

	$(document).on('blur' ,'textarea[name=yorum]',function() {
		
		$(this).parent().append($('<span/>').html($(this).val()));
		var id=$(this).attr("id");
		$(this).remove();
		
		
		
		
		$.post("http://localhost/PROJELER/mvcproje/uye/YorumGuncelle",{"yorumid":id,"yorum":$(this).val()},function(donen) {
			
			//alert(donen);
			
		window.location.reload();
		
	});		
	
		

		
		
	});

	//---------------------------------------------------------------------------

	$('#AdresGuncelButonlarinanasi input[type="button"]').click(function() {
		
		var id=$(this).attr('data-value');
		
		
		var textArea=$("<textarea id='"+id+"' name='adres' style='width:100%; height:100%;' />");
		
		
		textArea.val($(".adresSp"+id).html());
		$(".adresSp"+id).parent().append(textArea);
		$(".adresSp"+id).remove();
		input.focus();
		
	
		
		
	});

	$(document).on('blur' ,'textarea[name=adres]',function() {
		
		$(this).parent().append($('<span/>').html($(this).val()));
		var id=$(this).attr("id");
		$(this).remove();
		
		
		
		
		$.post("http://localhost/PROJELER/mvcproje/uye/AdresGuncelle",{"adresid":id,"adres":$(this).val()},function(donen) {
			
			//alert(donen);
			
		window.location.reload();
		
	});		
	
		

		
		
	});	

	var ad,soyad,mail,telefon;

	$('input[name=bilgiTercih]').on('change',function() {
		
	
		
		var gelenTercih=$(this).val(); // 0-1
		
		if (gelenTercih==1) 		
		{
			ad=$('input[id=sipAd]').val();
			soyad=$('input[id=sipSoyad]').val();
			mail=$('input[id=sipMail]').val();
			telefon=$('input[id=sipTlf]').val();
			
			
			 $('input[id=sipAd]').val("");
			 $('input[id=sipSoyad]').val("");
			 $('input[id=sipMail]').val("");
			 $('input[id=sipTlf]').val("");
			
		}
		
		else {
			
			 $('input[id=sipAd]').val(ad);
			 $('input[id=sipSoyad]').val(soyad);
			 $('input[id=sipMail]').val(mail);
			 $('input[id=sipTlf]').val(telefon);	
			
		}
		


		
	
	
		
	});

});

function VarsayilanYap(deger,deger2) {

		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/VarsayilanAdresYap",{"uyeid":deger, "adresid":deger2},function() {
			$.post("http://localhost/PROJELER/mvcproje/GenelGorev/VarsayilanAdresYap2",{"uyeid":deger, "adresid":deger2},function() {
	
				window.location.reload();
		
			});	
		
		});	
	
	}

function uyeyorumkontrol(yorumid,kriter) {

		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/uyeyorumkontrol",{"yorumid":yorumid, "kriter":kriter},function() {
	
			window.location.reload();
		
		});	
			
	}

function UrunSil(deger,kriter) {
	
	switch  (kriter) {
	
		case "sepetsil":
			
			$.post("http://localhost/PROJELER/mvcproje/GenelGorev/UrunSil",{"urunid":deger},function() {
		
				window.location.reload();
		
			});	

		break;
		
		case "yorumsil":

			$.post("http://localhost/PROJELER/mvcproje/uye/Yorumsil",{"yorumid":deger},function(donen) {
			
				if (donen)  {				
					
					$("#Sonuc").html("Yorum başarıyla silindi.");
					
				} else{
				
					$("#Sonuc").html("Silme işleminde hata oluştu.");
					
				}
		
				$("#Sonuc").fadeIn(1000,function() {
						
					$("#Sonuc").fadeOut(1000,function() {
							
						$("#Sonuc").html("");
							
						window.location.reload();				
					
						});

				});
		
			});	
		
		break;
		
		case "adresSil":
		
			$.post("http://localhost/PROJELER/mvcproje/uye/adresSil",{"adresid":deger},function(donen) {
			
				if (donen)  {				
				
					$("#Sonuc").html("Adres başarıyla silindi.");				
			
				} else{
				
					$("#Sonuc").html("Silme işleminde hata oluştu.");
			
				}
		
				$("#Sonuc").fadeIn(1000,function() {

					$("#Sonuc").fadeOut(1000,function() {
							
						$("#Sonuc").html("");
							
						window.location.reload();				
					
					});
					
				});
		
			});	

		break;
	
	}

}

function BilgiPenceresi(linkAdres,sonucbaslik,sonucmetin,sonuctur) {

	swal(sonucbaslik, sonucmetin, sonuctur, {
  
		buttons: {

			catch: {

				text: "KAPAT",
      
				value: "tamam",
    
			}
  
		},

	})

		.then((value) => {

		if (value=="tamam") {
   
			window.location.href =  linkAdres;
  
		}		
  
	});
	
}

function silmedenSor (gidilecekLink) {

	swal({
  
		title: "Silmek istediğine emin misin?",
  
		text: "Silinen kayıt geri alınamaz.",
  
		icon: "warning",
  
		buttons: true,
  
		dangerMode: true,

	})

		.then((willDelete) => {
  
		if (willDelete) {
     
			window.location.href =  gidilecekLink; 
  
		} else {
    
			swal({title:"Silme işleminden vazgeçtiniz", icon: "warning",});
  
		}

	});
	
}











