<?php

class Database extends PDO {


	protected $dizi=array();
	protected $dizi2=array();
	
	
	function __construct() {
			
parent::__construct('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',DB_USER,DB_PASS);
	
		$this->bilgi= new Bilgi();
		
		
	}
	
	
	function Ekle($tabloisim,$sutunadlari,$veriler) {		
		
		$sutunsayi=count($sutunadlari);	
		for ($i=0; $i<$sutunsayi; $i++) :		
		$this->dizi[]='?';
		endfor;
		
		$sonVal=join (",",$this->dizi);					
		$sonhal=join (",",$sutunadlari);		
		
		$sorgu=$this->prepare('insert into '.$tabloisim.' ('.$sonhal.') 	
		VALUES('.$sonVal.')'); 
		
		
		if ($sorgu->execute($veriler)) : 
		return true;	
		else:		
		return false;	
		
		endif;
		
		
	} // ekleme 
	
	function listele($tabloisim,$kosul=false) {
		
		
		if ($kosul==false) :
		
		$sorgum="select * from ".$tabloisim;
		
		else:
		
		$sorgum="select * from ".$tabloisim." ".$kosul;
												
		endif;
		
		$son=$this->prepare($sorgum);
		$son->execute();
		
		return $son->fetchAll();
		
		
	} // listeleme
	
	function teklistele($sutun,$kosul) {

	
		$son=$this->prepare("select " .$sutun. " ".$kosul);
		$son->execute();
		$veri=$son->fetch(PDO::FETCH_ASSOC);
		return $veri[$sutun];
		
		
	} //tekli listeleme
	
	
	function sil($tabloisim,$kosul) {
		
		$sorgum=$this->prepare("delete from ".$tabloisim. ' where '.$kosul);
		
		if ($sorgum->execute()) :
		
		return true;	
		else:		
		return false;		
		
		endif;
		
	} // silme	
	
	function guncelle($tabloisim,$sutunlar,$veriler,$kosul) {
		
		
		foreach ($sutunlar as $deger) :
		
		$this->dizi2[]=$deger."=?";
		
		endforeach;
		
		$sonSutunlar=join (",",$this->dizi2);			
		
		
		
	$sorgum=$this->prepare("update ".$tabloisim." set ".$sonSutunlar." where ".$kosul);	
		

	if ($sorgum->execute($veriler)) :
		
		return true;	
		else:		
		return false;		
		
		endif;


		
	} // güncelleme	
	
	function arama($tabloisim,$kosul) {
		
		
		$sorgum="select * from ".$tabloisim." where ".$kosul;							
		
		
		$son=$this->prepare($sorgum);
		$son->execute();
		
		return $son->fetchAll();
				
		
		
	} // arama		
	
	function giriskontrol($tabloisim,$kosul) {
		
		
		$sorgum="select * from ".$tabloisim." where ".$kosul;
		$son=$this->prepare($sorgum);
		$son->execute();
		
		if ($son->rowCount()>0) :
		
		return $son->fetchAll();
		
		else:
		
		return false;
		
		
		endif;
		

		
	} // giriş kontrol
	
	
	function siparisTamamla($veriler=array()) {
		

		
		$sorgu=$this->prepare('insert into siparisler (siparis_no,adresid,uyeid,urunad,urunadet,urunfiyat,toplamfiyat,odemeturu,tarih) 	
		VALUES(?,?,?,?,?,?,?,?,?)'); 
		
		
		$sorgu->execute($veriler);
		
		
		
	}
	
	
	function sistembakim ($deger) {
		$sorgu=$this->prepare('SHOW TABLES');
		$sorgu->execute();
		
		if ($sorgu->execute()) : 
			$tablolar=$sorgu->fetchAll();
		
				    foreach ($tablolar as $tabloadi):
		
					$this->query("REPAIR TABLE ".$tabloadi["Tables_in_".$deger.""]);
					$this->query("OPTIMIZE TABLE ".$tabloadi["Tables_in_".$deger.""]); 
	
					
				

					endforeach; 
					return true;
			
		else:		
		return false;	
		
		endif;
		
		$tablolar=$sorgu->fetchAll();
		
	
		
		 
			
		
		
	}//SİSTEM BAKIM
	
	function sayfalamaAdet($tabload){
		$cek=$this->prepare("select COUNT(*) AS toplam from ". $tabload);
		$cek->execute();
		$son=$cek->fetch(PDO::FETCH_ASSOC);
		
		return $son["toplam"];
		
		
	} //SAYFALAMA TOPLAM ADET
	
    function joinislemi($istenilenveriler,$tablolar,$kosul) {
	/*
	 $sorgum="select
		ana_kategori.ad As anakatad,
		cocuk_kategori.ad As cocukkatad,
		alt_kategori.ad As altad,
		alt_kategori.id As altid
		from
		ana_kategori JOIN cocuk_kategori JOIN alt_kategori
		ON
		(ana_kategori.id=cocuk_kategori.ana_kat_id) AND(cocuk_kategori.id=alt_kategori.cocuk_kat_id)
		AND 
		alt_kategori.ad LIKE '%Çamaşır%'";
	
	*/
		
		$sonveriler=join (",",$istenilenveriler);
		$tablolar=join (" JOIN ",$tablolar);
		
	
	
	    $sorgum="select
		".$sonveriler."
		from
		".$tablolar."
		ON ". $kosul;
		
	
		
	
	
		$son=$this->prepare($sorgum);
		$son->execute();
		
		return $son->fetchAll();
				
		
		
	} // JOIN


	
}




?>