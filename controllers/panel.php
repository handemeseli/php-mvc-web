<?php

class panel extends Controller  {
	
	
	function __construct() {
		
		parent::KutuphaneYukle(array("view","form","bilgi","Upload","Pagination"));
		
	$this->Modelyukle('adminpanel');
	Session::init();
	
		if (!Session::get("AdminAd") && !Session::get("Adminid")) : 

		
		$this->giris();
		
	
		exit();
		endif;


	
	}	// construct	

	function giris() {
		
		if (Session::get("AdminAd") && Session::get("Adminid")) : 
		
		$this->bilgi->direktYonlen("/panel/siparisler");

		else:
		
		$this->view->goster("YonPanel/sayfalar/index");
	
		endif;
		
	} // LOGİN GİRİŞ SAYFASI	
	
	function Index() {
		
	
	$this->siparisler();
		
	} // VARSAYILAN OLARAK ÇALIŞIYOR

	
	//----------------------------------------------
	
	function siparisler() {
			
			
	$this->view->goster("YonPanel/sayfalar/siparis",array(
	
	"data" => $this->model->Verial("siparisler","order by id desc")
	
	));		
	
	
		
	} // SİPARİŞLERİN ANA EKRANI	
	
	function kargoguncelle($sipno) {
			
			
	$this->view->goster("YonPanel/sayfalar/siparis",array(
	
	"KargoGuncelle" => $this->model->Verial("siparisler","where siparis_no=".$sipno)
	
	));		
	
	
		
	}  // KARGO DURUM GÜNCELLEME
	
	function kargoguncelleSon() {
			
				if ($_POST) :	
		
				$sipno=$this->form->get("sipno")->bosmu();
				$durum=$this->form->get("durum")->bosmu();
				
				
		$sonuc=$this->model->Guncelle("siparisler",
		array("kargodurum"),
		array($durum),"siparis_no=".$sipno);
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/siparis",
			array(
			"bilgi" => $this->bilgi->basarili("GÜNCELLEME BAŞARILI","/panel/siparisler")
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/siparis",
			array(
			"data" => $this->model->Verial("siparisler",false),
			"bilgi" => $this->bilgi->uyari("danger","Güncelleme sırasında hata oluştu.")
			 ));	
		
		endif;
				
			else:
			$this->bilgi->direktYonlen("/panel/siparisler");
				
	
				endif;
	
		
	} // KARGO DURUM GÜNCELLEME SON	
	
	function siparisarama() {	
		
		if ($_POST) :
		$aramatercih=$this->form->get("aramatercih")->bosmu();
		
		$aramaverisi=$this->form->get("aramaverisi")->bosmu();
		
		
		
				if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/siparis",
			array(		
			"bilgi" => $this->bilgi->hata("BİLGİ GİRİLMELİDİR.","/panel/siparisler",1)
			 ));
				
				
				else:
				
				
		if ($aramatercih=="sipno") :
				
				
			$this->view->goster("YonPanel/sayfalar/siparis",array(
	
			"data" => $this->model->arama("siparisler","siparis_no LIKE '".$aramaverisi."'")));	
			
			elseif($aramatercih=="uyebilgi"):
			
			
			$bilgicek=$this->model->arama("uye_panel",
			"id LIKE '%".$aramaverisi."%' or 
			ad LIKE '%".$aramaverisi."%'  or 
			soyad LIKE '%".$aramaverisi."%' or 
			telefon LIKE '%".$aramaverisi."%'");
			
				if ($bilgicek):
			
				$this->view->goster("YonPanel/sayfalar/siparis",array(				
				"data" => $bilgicek				
				));		
				
				else:
				
				$this->view->goster("YonPanel/sayfalar/siparis",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/siparisler",2)
				 ));			
				endif;
				
		endif;
				
		
		
				
				endif;
		
		
		
		else:
			$this->bilgi->direktYonlen("/panel/siparisler");		
		
		
		endif;
	
			

	
		
	} // SİPARİŞ ARAMA
	
	//----------------------------------------------
	
	function kategoriler() {
			
			
	$this->view->goster("YonPanel/sayfalar/kategoriler",array(
	
	"anakategori" => $this->model->Verial("ana_kategori",false),
	"cocukkategori" => $this->model->Verial("cocuk_kategori",false),
	"altkategori" => $this->model->Verial("alt_kategori",false)
	
	
	
	));		
	
	
		
	} // KATEGORİLER GELİYOR	
	
	function kategoriGuncelle($kriter,$id) {
		
	
				
	$this->view->goster("YonPanel/sayfalar/kategoriguncelleme",array(
	
	"data" => $this->model->Verial($kriter."_kategori","where id=".$id),
	"kriter" => $kriter,
	"AnaktegorilerTumu" => $this->model->Verial("ana_kategori",false),
	"CocukkategorilerTumu" => $this->model->Verial("cocuk_kategori",false)
	
	));	
		
	
		
	} // KATEGORİLER GÜNCELLE	
	
	function kategoriGuncelSon() {
		
	
		
			if ($_POST) :	
				$kriter=$this->form->get("kriter")->bosmu();
				$kayitid=$this->form->get("kayitid")->bosmu();
				$katad=$this->form->get("katad")->bosmu();
				
				@$anakatid=$_POST["anakatid"];
				@$cocukkatid=$_POST["cocukkatid"];
		
				
				
				if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/kategoriguncelleme",
			array(		
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARISIZ","Kategori adı boş olamaz.","warning")
	));
	
			 		
				
			else:	
				
		
		
		if ($kriter=="ana") :
		
		$sonuc=$this->model->Guncelle("ana_kategori",
		array("ad"),
		array($katad),"id=".$kayitid);
				
		elseif($kriter=="cocuk") :
		
		
		$sonuc=$this->model->Guncelle("cocuk_kategori",
		array("ana_kat_id","ad"),
		array($anakatid,$katad),"id=".$kayitid);
		
	
			
		elseif($kriter=="alt") :
		
		$sonuc=$this->model->Guncelle("alt_kategori",
		array("cocuk_kat_id","ana_kat_id","ad"),
		array($cocukkatid,$anakatid,$katad),"id=".$kayitid);
		endif;
		
				
				
				
				
		
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/kategoriguncelleme",
			array(
				
				
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARILI","GÜNCELLEME BAŞARILI","success")	
				
			 ));
				
		else:
		
		
		
			$this->view->goster("YonPanel/sayfalar/kategoriguncelleme",
								
			array(
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARISIZ","GÜNCELLEME SIRASINDA HATA OLUŞTU.","warning")
				
			 ));	
		
		endif;
		
	
		
		endif;
		
				
			else:
			$this->bilgi->direktYonlen("/panel/kategoriler");
				
	
				endif;		
		
	
	
		
	} // KATEGORİLER GÜNCELLENENİYOR VE SON POST İŞLEMİ BURASI
	
	function kategoriSil($kriter,$id) {
	
		
	$sonuc=$this->model->Sil($kriter."_kategori","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/kategoriler",
			array(
	"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARILI","SİLME BAŞARILI","success")
				
		));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/kategoriler",
			array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARISIZ","SİLME SIRASINDA HATA OLUŞTU","warning")
				
			 ));	
		
		endif;
	

	
		
	} // KATEGORİ SİL
	
	function kategoriEkle($kriter) {
		
	$this->view->goster("YonPanel/sayfalar/kategoriEkle",
	array("kriter" => $kriter,
	"AnaktegorilerTumu" => $this->model->Verial("ana_kategori",false),
	"CocukkategorilerTumu" => $this->model->Verial("cocuk_kategori",false)));		
		
		
	} // KATEGORİ EKLE
	
	function kategoriEkleSon() {
	
	
			
		
			if ($_POST) :	
				$kriter=$this->form->get("kriter")->bosmu();		
				$katad=$this->form->get("katad")->bosmu();
				
				@$anakatid=$_POST["anakatid"];
				@$cocukkatid=$_POST["cocukkatid"];
		
				
				
				if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/kategoriekle",
			array(	
				
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARISIZ","Kategori adı girilmelidir.","warning")
				
			
			 ));		
				
			else:	
				
		
		
		if ($kriter=="ana") :
		
		$sonuc=$this->model->Ekleme("ana_kategori",
		array("ad"),
		array($katad));
				
		elseif($kriter=="cocuk") :
		
		
		$sonuc=$this->model->Ekleme("cocuk_kategori",
		array("ana_kat_id","ad"),
		array($anakatid,$katad));
		
	
			
		elseif($kriter=="alt") :
		
		$sonuc=$this->model->Ekleme("alt_kategori",
		array("cocuk_kat_id","ana_kat_id","ad"),
		array($cocukkatid,$anakatid,$katad));
		endif;
		
				
				
				
				
		
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/kategoriekle",
			array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARILI","EKLEME BAŞARILI","success")
			
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/kategoriekle",
			array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARISIZ","EKLEME SIRASINDA HATA OLUŞTU.","warning")
				
			
			 ));	
		
		endif;
		
	
		
		endif;
		
				
			else:
			$this->bilgi->direktYonlen("/panel/kategoriler");
				
	
				endif;		
		
	
		
	} // KATEGORİ EKLE SON
	
	function kategoriarama() {	
		
		if ($_POST) :
		$aramatercih=$this->form->get("aramatercih")->bosmu();
		
		$aramaverisi=$this->form->get("aramaverisi")->bosmu();
		
		
		
			   	if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/kategoriler",
			array(		
			"bilgi" => $this->bilgi->hata("Boş alan bırakılmamalıdır.","/panel/kategoriler",1)
			 ));
				
				
				else:
				
				
		    if ($aramatercih=="ana") :
				
			$bilgicek=$this->model->arama("ana_kategori",
			"ad LIKE '%".$aramaverisi."%'");
			
			
			elseif($aramatercih=="cocuk"):
		
		
		    $bilgicek=$this->model->joinislemi(
			array(
			"ana_kategori.ad As anakatad",
			"cocuk_kategori.ad As cocukad",
			"cocuk_kategori.id As cocukid"	
			),
			array(
			"ana_kategori",
			"cocuk_kategori"
			),
			"ana_kategori.id=cocuk_kategori.ana_kat_id AND
		
		 cocuk_kategori.ad LIKE '%".$aramaverisi."%'"
			);
			
		
		    elseif($aramatercih=="alt"):
			$bilgicek=$this->model->joinislemi(
			array(
			"ana_kategori.ad As anakatad",
			"cocuk_kategori.ad As cocukkatad",
			"alt_kategori.ad As altad",
			"alt_kategori.id As altid"	
			),
			array(
			"ana_kategori",
			"cocuk_kategori",
			"alt_kategori"
			),
			"(ana_kategori.id=cocuk_kategori.ana_kat_id) AND(cocuk_kategori.id=alt_kategori.cocuk_kat_id)
		AND 
		alt_kategori.ad LIKE '%".$aramaverisi."%'"
			);
		    
			
			endif;
			
				if ($bilgicek):
			
				$this->view->goster("YonPanel/sayfalar/kategoriler",array(				
				"kategoriaramasonuc" => $bilgicek,
				"kelime" =>	$aramaverisi,
			    "kategorimiz" =>$aramatercih
				));		
				
				else:
				
				$this->view->goster("YonPanel/sayfalar/kategoriler",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/kategoriler",2)
				 ));			
				endif;
				
		
				
		
		
				
				endif;
		
		
		
		else:
			$this->bilgi->direktYonlen("/panel/kategoriler");		
		
		
		endif;
	
			

	
		
	} // KATEGORİ ARAMA
	
	
	
	//----------------------------------------------
	
	function uyeler ($mevcutsayfa=false) {
		
		$this->Pagination->paginationOlustur($this->model->sayfalama("uye_panel"),$mevcutsayfa,$this->model->tekliveri("uyelerGoruntuAdet","from ayarlar"));
		
		
		$this->view->goster("YonPanel/sayfalar/uyeler",array(
		
		"data" => $this->model->Verial("uye_panel"," LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => $this->model->sayfalama("uye_panel")
		
		));
	
	
		
	} // ÜYELER GELİYOR	
		
	function uyeguncelleSon() {
			
			
			
				if ($_POST) :	
				
					$ad=$this->form->get("ad")->bosmu();
					$soyad=$this->form->get("soyad")->bosmu();
					$mail=$this->form->get("mail")->bosmu();
					$telefon=$this->form->get("telefon")->bosmu();
					//$durum=$this->form->get("durum")->bosmu();
					$uyeid=$this->form->get("uyeid")->bosmu();
					$durum=$_POST["durum"];
					
					if (!empty($this->form->error)) :
					
				$this->view->goster("YonPanel/sayfalar/uyeler",
				array(		
				"bilgi" => $this->bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/uyeler",2)
				 ));		
					
				else:	
					
			
		
		
			$sonuc=$this->model->Guncelle("uye_panel",
			array("ad","soyad","mail","telefon","durum"),
			array($ad,$soyad,$mail,$telefon,$durum),"id=".$uyeid);
					
		
			
		
			if ($sonuc): 
		
				$this->view->goster("YonPanel/sayfalar/uyeler",
				array(
				"bilgi" => $this->bilgi->basarili("GÜNCELLEME BAŞARILI","/panel/uyeler",2)
				 ));
					
			else:
			
				$this->view->goster("YonPanel/sayfalar/uyeler",
				array(
				"bilgi" => $this->bilgi->hata("GÜNCELLEME SIRASINDA HATA OLUŞTU.","/panel/uyeler",2)
				 ));	
			
			endif;
			
		
			
			endif;
			
					
				else:
				$this->bilgi->direktYonlen("/panel/uyeler");
					
		
					endif;		
			
		
		
			
		} // ÜYELER GÜNCEL SON	
	
	function uyeGuncelle($id) {
		
	
				
	$this->view->goster("YonPanel/sayfalar/uyeler",array(	
	"Uyeguncelle" => $this->model->Verial("uye_panel","where id=".$id)	
	));	
		
	
		
	} // ÜYELER GÜNCELLE	
		
	function uyeSil($id) {
	
		
	$sonuc=$this->model->Sil("uye_panel","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/uyeler",
			array(
			"bilgi" => $this->bilgi->basarili("SİLME BAŞARILI","/panel/uyeler",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/uyeler",
			array(
			"bilgi" => $this->bilgi->hata("SİLME SIRASINDA HATA OLUŞTU.","/panel/uyeler",2)
			 ));	
		
		endif;
	

	
		
	}  // ÜYE SİL	
		
	function uyearama($kelime=false,$mevcutsayfa=false) {	
		
		
		if ($_POST) :
				
		$aramaverisi=$this->form->get("aramaverisi")->bosmu();
		
		
		
				if (!empty($this->form->error)) :
				
				$this->view->goster("YonPanel/sayfalar/uyeler",
				array(		
				"bilgi" => $this->bilgi->hata("KRİTER GİRİLMELİDİR.","/panel/uyeler",2)
				 ));
				
				
				else:
		    $bilgicek=$this->model->arama("uye_panel",
			"id LIKE '%".$aramaverisi."%' or 
			ad LIKE '%".$aramaverisi."%'  or 
			soyad LIKE '%".$aramaverisi."%' or 
			telefon LIKE '%".$aramaverisi."%'");
		
		    $this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("uyelerAramaAdet","from ayarlar"));
				
		
		
				if (count($bilgicek)>0):
			
				$this->view->goster("YonPanel/sayfalar/uyeler",array(
				
				"data" => $this->model->arama("uye_panel",
			"id LIKE '%".$aramaverisi."%' or 
			ad LIKE '%".$aramaverisi."%'  or 
			soyad LIKE '%".$aramaverisi."%' or 
			telefon LIKE '%".$aramaverisi."%' LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => count($bilgicek),
		"arama" => $aramaverisi
		
		
				
				));		
				
				else:
		
				
				$this->view->goster("YonPanel/sayfalar/uyeler",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/uyeler",2)
				 ));			
				endif;
	
				
				endif;
		
		elseif(isset($kelime)):
			$bilgicek=$this->model->arama("uye_panel",
			"id LIKE '%".$kelime."%' or 
			ad LIKE '%".$kelime."%'  or 
			soyad LIKE '%".$kelime."%' or 
			telefon LIKE '%".$kelime."%'");
		    $this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("uyelerAramaAdet","from ayarlar"));
		
		$this->view->goster("YonPanel/sayfalar/uyeler",array(
				
				"data" => $this->model->arama("uye_panel",
			"id LIKE '%".$kelime."%' or 
			ad LIKE '%".$kelime."%'  or 
			soyad LIKE '%".$kelime."%' or 
			telefon LIKE '%".$kelime."%' LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => count($bilgicek),
		"arama" => $kelime
		
		
				
				));		
				
		
		
		else:
			$this->bilgi->direktYonlen("/panel/uyeler");		
		
		
		endif;
	
			

	
		
	} // ÜYE ARAMA
	
	function uyeadresbak($id) {
		
	
				
	$this->view->goster("YonPanel/sayfalar/uyeler",array(	
	"UyeadresBak" => $this->model->Verial("adresler","where uyeid=".$id)	
	));	
		
	
		
	} // ÜYE ADRESLERİ
	
	function musteriyorumlar ($mevcutsayfa=false) {
		
		$this->Pagination->paginationOlustur($this->model->sayfalama("yorumlar"),$mevcutsayfa,$this->model->tekliveri("uyelerYorumAdet","from ayarlar"));
		
		
		
		
		$this->view->goster("YonPanel/sayfalar/musteriyorumlar",array(
		
		"data" => $this->model->joinislemi(
		array(
		"urunler.urunad As urunad",
		"yorumlar.*"
			
		),
		array(
		"urunler",
		"yorumlar"
		),
		"yorumlar.urunid=urunler.id order by durum asc LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet
		), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => $this->model->sayfalama("yorumlar")
		
		));
	
	
		
	} // ÜYELERİN YORUMLARI
	
	//----------------------------------------------
	
	function urunler ($mevcutsayfa=false) {
		
		$this->Pagination->paginationOlustur($this->model->sayfalama("urunler"),$mevcutsayfa,$this->model->tekliveri("urunlerGoruntuAdet","from ayarlar"));
		
		$this->view->goster("YonPanel/sayfalar/urunler",array(
		
		"data" => $this->model->Verial("urunler"," LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => $this->model->sayfalama("urunler"),
		"data2" => $this->model->Verial("alt_kategori",false)
		
		));
		
	
	
		
	}  // ÜRÜNLER GELİYOR
	
	function urunGuncelle($id) {
		
	
				
	$this->view->goster("YonPanel/sayfalar/urunler",array(	
	"Urunguncelle" => $this->model->Verial("urunler","where id=".$id),
	"data2" => $this->model->Verial("alt_kategori",false)		
	));	
		
	
		
	} // ÜRÜNLER GÜNCELLE	
	
	function urunguncelleSon() {	
		
		
			if ($_POST) :	
			
				$urunad=$this->form->get("urunad")->bosmu();
				$katid=$this->form->get("katid")->bosmu();
				$kumas=$this->form->get("kumas")->bosmu();
				$uretimyeri=$this->form->get("uretimyeri")->bosmu();
				$renk=$this->form->get("renk")->bosmu();
				$fiyat=$this->form->get("fiyat")->bosmu();
				$stok=$this->form->get("stok")->bosmu();
				$durum=$this->form->get("durum")->bosmu();
				$urunaciklama=$this->form->get("urunaciklama")->bosmu();
				$urunozellik=$this->form->get("urunozellik")->bosmu();
				$urunekstra=$this->form->get("urunekstra")->bosmu();
				$kayitid=$this->form->get("kayitid")->bosmu();
				
				
		
				
if ($this->Upload->uploadPostAl("res1")) : $this->Upload->UploadDosyaKontrol("res1");	endif;	

if ($this->Upload->uploadPostAl("res2")) : $this->Upload->UploadDosyaKontrol("res2");	endif;	
				
if ($this->Upload->uploadPostAl("res3")) : $this->Upload->UploadDosyaKontrol("res3");	endif;				
		
		
				
			
				
			if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(		
			"bilgi" => $this->bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/urunler",2)
			 ));
			 
			elseif (!empty($this->Upload->error)) :
				
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(		
			"bilgi" => $this->Upload->error,
			"yonlen" =>$this->bilgi->sureliYonlen(3,"/panel/urunler") 
			 ));	
		
	
				
			else:	
				
		
			
			
			$sutunlar=array("katid","urunad","durum","aciklama","kumas","urtYeri","renk","fiyat","stok","ozellik","ekstraBilgi");
			
			$veriler=array($katid,$urunad,$durum,$urunaciklama,$kumas,$uretimyeri,$renk,$fiyat,$stok,$urunozellik,$urunekstra);
			
			
 if ($this->Upload->uploadPostAl("res1")) :
 	$sutunlar[]="res1"; 
	$veriler[]=$this->Upload->Yukle("res1",true); 
 endif;	

 if ($this->Upload->uploadPostAl("res2")) :
 	$sutunlar[]="res2"; 
	$veriler[]=$this->Upload->Yukle("res2",true); 
 endif;	
  if ($this->Upload->uploadPostAl("res3")) :
 	$sutunlar[]="res3"; 
	$veriler[]=$this->Upload->Yukle("res3",true); 
 endif;	
			
		
	
		$sonuc=$this->model->Guncelle("urunler",
		$sutunlar,
		$veriler,"id=".$kayitid);
				
	
		
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->basarili("ÜRÜN BAŞARIYLA GÜNCELLENDİ","/panel/urunler",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->hata("GÜNCELLEME SIRASINDA HATA OLUŞTU.","/panel/urunler",2)
			 ));	
		
		endif;
		
	
		
		endif;
		
				
			else:
			$this->bilgi->direktYonlen("/panel/urunler");
				
	
	endif;		
		
		
		
	
	
		
	} // ÜRÜNLER GÜNCEL SON
	
	function Urunekleme() {	
				
	$this->view->goster("YonPanel/sayfalar/urunler",array(	
	"Urunekleme" => true,
	"data2" => $this->model->Verial("alt_kategori",false)		
	));	
		
	
		
	}	 // ÜRÜN EKLEME
	
	function urunekle() {	
		
		
			if ($_POST) :	
			
				$urunad=$this->form->get("urunad")->bosmu();
				$katid=$this->form->get("katid")->bosmu();
				$kumas=$this->form->get("kumas")->bosmu();
				$uretimyeri=$this->form->get("uretimyeri")->bosmu();
				$renk=$this->form->get("renk")->bosmu();
				$fiyat=$this->form->get("fiyat")->bosmu();
				$stok=$this->form->get("stok")->bosmu();
				$durum=$this->form->get("durum")->bosmu();
				$urunaciklama=$this->form->get("urunaciklama")->bosmu();
				$urunozellik=$this->form->get("urunozellik")->bosmu();
				$urunekstra=$this->form->get("urunekstra")->bosmu();
			
			$this->Upload->UploadResimYeniEkleme("res",3);
				
			
				
				if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(		
			"bilgi" => $this->bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/urunler",2)
			 ));	
			 
			 	elseif (!empty($this->Upload->error)) :
				
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(		
			"bilgi" => $this->Upload->error
			 ));	
				
			else:	
				
		
				$dosyayukleme=$this->Upload->Yukle();
	
		$sonuc=$this->model->Ekleme("urunler",
		array("katid","urunad","res1","res2","res3","durum","aciklama","kumas","urtYeri","renk","fiyat","stok","ozellik","ekstraBilgi"),
		array($katid,$urunad,$dosyayukleme[0],$dosyayukleme[1],$dosyayukleme[2],$durum,$urunaciklama,$kumas,$uretimyeri,$renk,$fiyat,$stok,$urunozellik,$urunekstra));
				
	
		
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->basarili("ÜRÜN BAŞARIYLA EKLENDİ","/panel/urunler",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->hata("EKLEME SIRASINDA HATA OLUŞTU.","/panel/urunler",2)
			 ));	
		
		endif;
		
	
		
		endif;
		
				
			else:
			$this->bilgi->direktYonlen("/panel/urunler");
				
	
	endif;		
		
		
		
	
	
		
	}	 // ÜRÜN EKLEME SON	
		
	function urunSil($id) {
	
		
	$sonuc=$this->model->Sil("urunler","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->basarili("SİLME BAŞARILI","/panel/urunler",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->hata("SİLME SIRASINDA HATA OLUŞTU.","/panel/urunler",2)
			 ));	
		
		endif;
	

	
		
	}  // ÜRÜNLER SİL	
	
	function katgoregetir($katid=false,$mevcutsayfa=false) {	
		
		if ($_POST) :
				
		$katid=$this->form->get("katid")->bosmu();
		
		
		$bilgicek=$this->model->Verial("urunler","where katid=".$katid);
		
	
			
		$this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerKategoriAdet","from ayarlar"));
		
				if ($bilgicek):
			
				$this->view->goster("YonPanel/sayfalar/urunler",array(
				
				"data" => $this->model->Verial("urunler","where katid=".$katid." LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
				"toplamsayfa" => $this->Pagination->toplamsayfa,
				"toplamveri" => count($bilgicek),
				"katid" => $katid,	
				"data2" => $this->model->Verial("alt_kategori",false)			
				));	
		
			
				
				else:
				
				$this->view->goster("YonPanel/sayfalar/urunler",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/urunler",2)
				 ));			
				endif;
	
		elseif(isset($katid)):
		$bilgicek=$this->model->Verial("urunler","where katid=".$katid);
		
	
		$this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerKategoriAdet","from ayarlar"));
		
		
		$this->view->goster("YonPanel/sayfalar/urunler",array(
				"data" => $this->model->Verial("urunler","where katid=".$katid." LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
				"toplamsayfa" => $this->Pagination->toplamsayfa,
				"toplamveri" => count($bilgicek),
				"katid" => $katid,	
				"data2" => $this->model->Verial("alt_kategori",false)			
				));	
		
			
		
		
		
		else:
			$this->bilgi->direktYonlen("/panel/urunler");		
		
		
		endif;
	
			

	
		
	} // ÜRÜNLERi KATEGORİYE GÖRE GETİR	
	
	function urunarama($kelime=false,$mevcutsayfa=false) {	
		
		if ($_POST) :
				
		$aramaverisi=$this->form->get("arama")->bosmu();
		
		
		
				if (!empty($this->form->error)) :
				
				$this->view->goster("YonPanel/sayfalar/urunler",
				array(		
				"bilgi" => $this->bilgi->hata("KRİTER GİRİLMELİDİR.","/panel/urunler",2)
				 ));
				
				
				else:
				
			
			
			$bilgicek=$this->model->arama("urunler",
			"urunad LIKE '%".$aramaverisi."%' or 
			kumas LIKE '%".$aramaverisi."%'  or 
			urtYeri LIKE '%".$aramaverisi."%' or 
			stok LIKE '%".$aramaverisi."%'");
			
		$this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerAramaAdet","from ayarlar"));
		
				if (count($bilgicek)>0):
			
		
		    $this->view->goster("YonPanel/sayfalar/urunler",array(
			"data" => $this->model->arama("urunler",
			"urunad LIKE '%".$aramaverisi."%' or 
			kumas LIKE '%".$aramaverisi."%'  or 
			urtYeri LIKE '%".$aramaverisi."%' or 
			stok LIKE '%".$aramaverisi."%' LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => count($bilgicek),
		"arama" => $aramaverisi,
		"data2" => $this->model->Verial("alt_kategori",false)	
		));
				else:
				
				$this->view->goster("YonPanel/sayfalar/urunler",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/urunler",2)
				 ));			
				endif;
	
				
				endif;
		
		
		
		
		elseif(isset($kelime)):
		
			$bilgicek=$this->model->arama("urunler",
			"urunad LIKE '%".$kelime."%' or 
			kumas LIKE '%".$kelime."%'  or 
			urtYeri LIKE '%".$kelime."%' or 
			stok LIKE '%".$kelime."%'");
			
		$this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerAramaAdet","from ayarlar"));
		
		
		$this->view->goster("YonPanel/sayfalar/urunler",array(
			"data" => $this->model->arama("urunler",
			"urunad LIKE '%".$kelime."%' or 
			kumas LIKE '%".$kelime."%'  or 
			urtYeri LIKE '%".$kelime."%' or 
			stok LIKE '%".$kelime."%' LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => count($bilgicek),
		"arama" => $kelime,
		"data2" => $this->model->Verial("alt_kategori",false)	
		));
			
			
				
		
		
		
		else:
			$this->bilgi->direktYonlen("/panel/urunler");		
		
		
		endif;
	
			

	
		
	} // ÜRÜNLER ARAMA	
	
	//----------------------------------------------
	
	function bulten () {
		
		$this->view->goster("YonPanel/sayfalar/bulten",array(
		
		"data" => $this->model->Verial("bulten",false),
		
		));
	
	
		
	}  // BÜLTEN GELİYOR
	
	function mailSil($id) {
	
		
	$sonuc=$this->model->Sil("bulten","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/bulten",
			array(
			"bilgi" => $this->bilgi->basarili("SİLME BAŞARILI","/panel/bulten",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/bulten",
			array(
			"bilgi" => $this->bilgi->hata("SİLME SIRASINDA HATA OLUŞTU.","/panel/bulten",2)
			 ));	
		
		endif;
	

	
		
	}  // BÜLTEN MAİL SİL
	
	function mailarama() {	
		
		if ($_POST) :
				
		$aramaverisi=$this->form->get("arama")->bosmu();
		
		
		
				if (!empty($this->form->error)) :
				
				$this->view->goster("YonPanel/sayfalar/bulten",
				array(		
				"bilgi" => $this->bilgi->hata("MAİL YAZILMALIDIR.","/panel/bulten",2)
				 ));
				
				
				else:
				
			
			
			$bilgicek=$this->model->arama("bulten",
			"mailadres LIKE '%".$aramaverisi."%'");
			
				if ($bilgicek):
			
				$this->view->goster("YonPanel/sayfalar/bulten",array(
				
				"data" => $bilgicek				
				));		
				
				else:
				
				$this->view->goster("YonPanel/sayfalar/bulten",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/bulten",2)
				 ));			
				endif;
	
				
				endif;
		
		
		
		else:
			$this->bilgi->direktYonlen("/panel/bulten");		
		
		
		endif;
	
			

	
		
	} // BÜLTEN MAİL ARAMA
	
	function tarihegoregetir() {	
		
		if ($_POST) :
				
		$tar1=$this->form->get("tar1")->bosmu();
		$tar2=$this->form->get("tar2")->bosmu();
		
		
		
				if (!empty($this->form->error)) :
				
				$this->view->goster("YonPanel/sayfalar/bulten",
				array(		
				"bilgi" => $this->bilgi->hata("TARİHLER BELİRTİLMELİDİR.","/panel/bulten",2)
				 ));
				
				
				else:
				
			
			
			$bilgicek=$this->model->Verial("bulten",
			"where DATE(tarih) BETWEEN '".$tar1."' and '".$tar2."' ");
			
				if ($bilgicek):
			
				$this->view->goster("YonPanel/sayfalar/bulten",array(
				
				"data" => $bilgicek				
				));		
				
				else:
				
				$this->view->goster("YonPanel/sayfalar/bulten",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/bulten",2)
				 ));			
				endif;
	
				
				endif;
		
		
		
		else:
			$this->bilgi->direktYonlen("/panel/bulten");		
		
		
		endif;
	
			

	
		
	} // BÜLTEN TARİHE GÖRE ARAMA

	//----------------------------------------------
	
	function sistemayar () {
		
		$this->view->goster("YonPanel/sayfalar/sistemayar",array(
		
		"sistemayar" => $this->model->Verial("ayarlar",false),
		
		));
	
	
		
	}  // SİSTEM AYARLARI GELİYOR
	
	function ayarguncelle() {	
		
		
			if ($_POST) :	
			
				$sloganust1=$this->form->get("sloganust1")->bosmu();
				$sloganalt1=$this->form->get("sloganalt1")->bosmu();
				$sloganust2=$this->form->get("sloganust2")->bosmu();
				$sloganalt2=$this->form->get("sloganalt2")->bosmu();
				$sloganust3=$this->form->get("sloganust3")->bosmu();
				$sloganalt3=$this->form->get("sloganalt3")->bosmu();
				$sayfatitle=$this->form->get("sayfatitle")->bosmu();
				$sayfaaciklama=$this->form->get("sayfaaciklama")->bosmu();
				$anahtarkelime=$this->form->get("anahtarkelime")->bosmu();
		
		
		$uyeSayfaGorAdet=$this->form->get("uyeSayfaGorAdet")->bosmu();
		$uyeSayfaAramaAdet=$this->form->get("uyeSayfaAramaAdet")->bosmu();
		$urunlerSayfaGorAdet=$this->form->get("urunlerSayfaGorAdet")->bosmu();
		$urunAramaAdet=$this->form->get("urunAramaAdet")->bosmu();
		$urunlerKategoriAdet=$this->form->get("urunlerKategoriAdet")->bosmu();
		$SiteUrunlerAdet=$this->form->get("SiteUrunlerAdet")->bosmu();
		$uyeYorumAdet=$this->form->get("uyeYorumAdet")->bosmu();
		
		
		
		
		
				$kayitid=$this->form->get("kayitid")->bosmu();
			
				
				if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/sistemayar",
			array(		
			"bilgi" => $this->bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/sistemayar",2)
			 ));	
			 
			else:	
		
		$sonuc=$this->model->Guncelle("ayarlar",
		array("sloganUst1","sloganAlt1","sloganUst2","sloganAlt2","sloganUst3","sloganAlt3","title","sayfaAciklama","anahtarKelime","uyelerGoruntuAdet","uyelerAramaAdet","urunlerGoruntuAdet","urunlerAramaAdet","urunlerKategoriAdet","ArayuzurunlerGoruntuAdet","uyeYorumAdet"),
		array($sloganust1,$sloganalt1,$sloganust2,$sloganalt2,$sloganust3,$sloganalt3,$sayfatitle,$sayfaaciklama,$anahtarkelime,$uyeSayfaGorAdet,$uyeSayfaAramaAdet,$urunlerSayfaGorAdet,$urunAramaAdet,$urunlerKategoriAdet,$SiteUrunlerAdet,$uyeYorumAdet),"id=".$kayitid);
				
	
		
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/sistemayar",
			array(
			"bilgi" => $this->bilgi->basarili("SİSTEM AYARLARI BAŞARIYLA GÜNCELLENDİ","/panel/sistemayar",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/sistemayar",
			array(
			"bilgi" => $this->bilgi->hata("GÜNCELLEME SIRASINDA HATA OLUŞTU.","/panel/sistemayar",2)
			 ));	
		
		endif;
		
	
		
		endif;
		
				
			else:
			$this->bilgi->direktYonlen("/panel/sistemayar");
				
	
	endif;		
		
		
		
	
	
		
	}	 // SİSTEM AYARLARI GÜNCELLEME SON
	
	
	//----------------------------------------------
	
	function sistembakim () {
		
		$this->view->goster("YonPanel/sayfalar/bakim",array(
		
		"sistembakim" => true
		
		));
	
	
		
	}  // SİSTEM BAKIM
		
	
	function bakimyap () {
			
			if ($_POST["sistembtn"]):
			
			$bakim=$this->model->bakim("mvcproje");
		
	
				if ($bakim):
	
			$this->view->goster("YonPanel/sayfalar/bakim",
			array(
			"bilgi" => $this->bilgi->basarili("SİSTEM BAKIMI BAŞARIYLA YAPILDI","/panel/sistembakim",2)
			 ));
				
				else:
		
			$this->view->goster("YonPanel/sayfalar/bakim",
			array(
			"bilgi" => $this->bilgi->hata("BAKIM SIRASINDA HATA OLUŞTU.","/panel/sistembakim",2)
			 ));	
		
				endif;
		
		
				
			else:
			$this->bilgi->direktYonlen("/panel/sistembakim");
			
			endif;		
	
		
	} //SİSTEM BAKIM SONUÇ
	
	//----------------------------------------------

	
	/*
	function kayitkontrol() {
	
	if ($_POST) :		
	$ad=$this->form->get("ad")->bosmu();
	$soyad=$this->form->get("soyad")->bosmu();
	$mail=$this->form->get("mail")->bosmu();
	$sifre=$this->form->get("sifre")->bosmu();
	$sifretekrar=$this->form->get("sifretekrar")->bosmu();
	$telefon=$this->form->get("telefon")->bosmu();	
	$this->form->GercektenMailmi($mail);	
	$sifre=$this->form->SifreTekrar($sifre,$sifretekrar);
	

	
	if (!empty($this->form->error)) :
	

	$this->view->goster("sayfalar/uyeol",
	array("hata" => $this->form->error));
	
	
	else:
	

	
	$sonuc=$this->model->Ekleİslemi("uye_panel",
	array("ad","soyad","mail","sifre","telefon"),
	array($ad,$soyad,$mail,$sifre,$telefon));
	
		if ($sonuc):
	
	
		$this->view->goster("sayfalar/uyeol",
		array("bilgi" =>$this->bilgi->uyari("success","KAYIT BAŞARILI")));
		
		
		
		else:
		
		$this->view->goster("sayfalar/uyeol",
		array("bilgi" => 
		$this->bilgi->uyari("danger","Kayıt esnasında hata oluştu")));
		
		
		
		
		endif;
	
	endif;
		
		else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	
	
		
	} 	// KAYIT KONTROL	*/	
	
	function cikis() {
			
			Session::destroy();			
			$this->bilgi->direktYonlen("/panel/giris");
		
	} // ÇIKIŞ	
	
	function sifredegistir() {	
	
	
	$this->view->goster("YonPanel/sayfalar/sifreislemleri",array(
	"sifredegistir" => Session::get("Adminid")));	
	
		
	} // ŞİFRE DEĞİŞTİRME FORMU
	
	function sifreguncelleson() {		

	if ($_POST) :		
		
	 $mevcutsifre=$this->form->get("mevcutsifre")->bosmu();
	 $yen1=$this->form->get("yen1")->bosmu();
	 $yen2=$this->form->get("yen2")->bosmu();
	 $yonid=$this->form->get("yonid")->bosmu();
	 $sifre=$this->form->SifreTekrar($yen1,$yen2); // ŞİFRELİ YENİ HALİ ALIYORUM
	/*
	ÖNCE GELEN ŞFİREYİ SORGULAMAM LAZIM DOĞRUMU DİYE, EĞER MEVCUT ŞİFRE DOĞRU İSE	
	DEVAM EDECEK HATALI İSE İŞLEM BİTECEK
	
	*/
	
	$mevcutsifre=$this->form->sifrele($mevcutsifre);
	
	if (!empty($this->form->error)) :
		
	$this->view->goster("YonPanel/sayfalar/sifreislemleri",
	array(
	"sifredegistir" => Session::get("Adminid"),
	"bilgi" => $this->bilgi->uyari("danger","Girilen bilgiler hatalıdır.")
	 ));
	
	else:	
	
	$sonuc2=$this->model->GirisKontrol("yonetim","ad='".Session::get("AdminAd")."' and sifre='$mevcutsifre'");
	
		if ($sonuc2): 
		
				$sonuc=$this->model->Guncelle("yonetim",
				array("sifre"),
				array($sifre),"id=".$yonid);
			
				if ($sonuc): 
				
			
				$this->view->goster("YonPanel/sayfalar/sifreislemleri",
				array(
				"bilgi" => $this->bilgi->basarili("ŞİFRE DEĞİŞTİRME BAŞARILI","/panel/siparisler")
			 	));
					
						
				else:
				
				$this->view->goster("YonPanel/sayfalar/sifreislemleri",
				array(
				"sifredegistir" => Session::get("Adminid"),
				"bilgi" => $this->bilgi->uyari("danger","Şifre değiştirme sırasında hata oluştu.")
				));	
				
				endif;
			
		else:
		
		
		
		
		
			$this->view->goster("YonPanel/sayfalar/sifreislemleri",
	array(
	"sifredegistir" => Session::get("Adminid"),
	"bilgi" => $this->bilgi->uyari("danger","Mevcut şifre hatalıdır.")
	 ));
		
			
		
		endif;
	
	endif;
	
	
	else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	
	
		
	} // YÖNETİCİ ŞİFRESİNİ GÜNCELLİYOR.
	
	//----------------------------------------------
	
	function yonetici () {
		
		$this->view->goster("YonPanel/sayfalar/yonetici",array(
		
		"data" => $this->model->Verial("yonetim",false),
		
		));
	
	
		
	}  // YÖNETİCİLER GELİYOR
	
	function yonSil($id) {
	
		
	$sonuc=$this->model->Sil("yonetim","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/yonetici",
			array(
			"bilgi" => $this->bilgi->basarili("SİLME BAŞARILI","/panel/yonetici",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/yonetici",
			array(
			"bilgi" => $this->bilgi->hata("SİLME SIRASINDA HATA OLUŞTU.","/panel/yonetici",2)
			 ));	
		
		endif;
	

	
		
	}  // YÖNETİCİ SİL
	
	function yonekle() {	
				
	$this->view->goster("YonPanel/sayfalar/yonetici",array(	
	"yoneticiekle" => true		
	));	
		
	
		
	}	 // YÖNETİCİ EKLEME
	
	function yonekleson() {		

	if ($_POST) :		
		
	 $yonadi=$this->form->get("yonadi")->bosmu();
	 $sif1=$this->form->get("sif1")->bosmu();
	 $sif2=$this->form->get("sif2")->bosmu();
	 
	 $sifre=$this->form->SifreTekrar($sif1,$sif2); // ŞİFRELİ YENİ HALİ ALIYORUM
	/*
	ÖNCE GELEN ŞFİREYİ SORGULAMAM LAZIM DOĞRUMU DİYE, EĞER MEVCUT ŞİFRE DOĞRU İSE	
	DEVAM EDECEK HATALI İSE İŞLEM BİTECEK
	
	*/
	
	if (!empty($this->form->error)) :
		
	$this->view->goster("YonPanel/sayfalar/yonetici",
	array(
	"bilgi" => $this->bilgi->hata("Girilen bilgiler hatalıdır.","/panel/yonetici")
	 ));
	
	else:	
	

		
				$sonuc=$this->model->Ekleme("yonetim",
				array("ad","sifre"),
				array($yonadi,$sifre));
			
				if ($sonuc): 
				
			
				$this->view->goster("YonPanel/sayfalar/yonetici",
				array(
				"bilgi" => $this->bilgi->basarili("Yeni yönetici eklendi.","/panel/yonetici")
			 	));
					
						
				else:
				
				$this->view->goster("YonPanel/sayfalar/yonetici",
				array(
				"sifredegistir" => Session::get("Adminid"),
				"bilgi" => $this->bilgi->hata("Ekleme sırasında hata oluştu.","/panel/yonetici")
				));	
				
				endif;
	
	endif;
	
	
	else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	
	
		
	} // YÖNETİCİ EKLEME SON.
	
	//--------------------------------------------------------------------------------------
	
	function bankabilgileri () {
		
		
		
		$this->view->goster("YonPanel/sayfalar/bankabilgileri",array(
		
		"data" => $this->model->Verial("bankabilgileri",false)
		
		
		));
	
	
		
	} // BANKA BİLGİLERİ GELİYOR
	
	function bankaGuncelle($islem,$id=false) {
		
	if ($islem=="ilk") :
		
	        $this->view->goster("YonPanel/sayfalar/bankabilgileri",array(	
	        "BankaGuncelle" => $this->model->Verial("bankabilgileri","where id=".$id)	
	        ));	
		
		
				
	elseif($islem=="son") :
		
		            if ($_POST) :	
				
					$banka_ad=$this->form->get("banka_ad")->bosmu();
					$hesap_ad=$this->form->get("hesap_ad")->bosmu();
					$hesap_no=$this->form->get("hesap_no")->bosmu();
					$iban_no=$this->form->get("iban_no")->bosmu();
					$bankaid=$this->form->get("bankaid")->bosmu();
					
					
					if (!empty($this->form->error)) :
					
				$this->view->goster("YonPanel/sayfalar/bankabilgileri",
				array(		
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARISIZ","Tüm alanlar doldurulmalıdır.","warning")
				 ));		
					
				else:	
					
			
		
		
			$sonuc=$this->model->Guncelle("bankabilgileri",
			array("banka_ad","hesap_ad","hesap_no","iban_no"),
			array($banka_ad,$hesap_ad,$hesap_no,$iban_no),"id=".$bankaid);
					
		 
			
		
			if ($sonuc): 
		
				$this->view->goster("YonPanel/sayfalar/bankabilgileri",
				array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARILI","HESAP GÜNCELLEME BAŞARILI","success")
				 ));
					
			else:
			
				$this->view->goster("YonPanel/sayfalar/bankabilgileri",
				array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARISIZ","GÜNCELLEME SIRASINDA HATA OLUŞTU.","warning")
				 ));	
			
			endif;
			
		
			
			endif;
			
					
				else:
				$this->bilgi->direktYonlen("/panel/bankabilgileri");
					
		
					endif;		
			
		
		
		
		
		
		endif;
	
		
	} // BANKA BİLGİLERİ GÜNCELLE
		
	
	
	
		
	function bankaSil($id) {
	
		
	$sonuc=$this->model->Sil("bankabilgileri","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/bankabilgileri",
			array(
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARILI","SİLME BAŞARILI","success")
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/uyeler",
			array(
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARISIZ","SİLME SIRASINDA HATA OLUŞTU","warning")
			 ));	
		
		endif;
	

	
		
	}  // BANKA BİLGİLERİ SİL	
		
	
	function bankaEkle($islem) {
		
	if($islem=="ilk") :
		
	$this->view->goster("YonPanel/sayfalar/bankabilgileri",array(	
	"BankaEkle" => true));		
		
	
		
	elseif($islem=="son") :		

	if ($_POST) :		
		
	                $banka_ad=$this->form->get("banka_ad")->bosmu();
					$hesap_ad=$this->form->get("hesap_ad")->bosmu();
					$hesap_no=$this->form->get("hesap_no")->bosmu();
					$iban_no=$this->form->get("iban_no")->bosmu();
					
	
	
	                if (!empty($this->form->error)) :
		
	                $this->view->goster("YonPanel/sayfalar/bankabilgileri",
	                array(
	                       "bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARISIZ","Girilen bilgiler hatalıdır.","warning")
	 ));
	
	else:	
	

		
				$sonuc=$this->model->Ekleme("bankabilgileri",
				array("banka_ad","hesap_ad","hesap_no","iban_no"),
				array($banka_ad,$hesap_ad,$hesap_no,$iban_no));
			
				if ($sonuc): 
				
			
				$this->view->goster("YonPanel/sayfalar/bankabilgileri",
				array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARILI","Yeni banka hesabı eklendi.","success")
			 	));
					
						
				else:
				
				$this->view->goster("YonPanel/sayfalar/bankabilgileri",
				array(
				
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARISIZ","Ekleme sırasında hata oluştu.","warning")
				));
				
				endif;
	
	endif;
	
	
	else:	
	
	$this->bilgi->direktYonlen("/panel/bankabilgileri");
	endif;
	
	
		
	
		
		
		
		
	endif;	
				
	
		
	
		
	} // BANKA BİLGİSİ EKLE
	
	
	

	
	
}


?>