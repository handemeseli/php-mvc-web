<?php

class adminpanel_model extends Model {
	
	
	function __construct() {		
		parent:: __construct();
	}
	
	function bakim($deger) {
		
		return $this->db->sistembakim($deger);
		
	}
	
	function Verial($tabloisim,$kosul) {
		
		return $this->db->listele($tabloisim,$kosul);
		
	}
	
	function Guncelle($tabloisim,$sutunlar,$veriler,$kosul) {
		
		
		return $this->db->guncelle($tabloisim,$sutunlar,$veriler,$kosul);
	}
	
	function Arama($tabloisim,$kosul) {
		
		
		return $this->db->arama($tabloisim,$kosul);
	}
	
	function Sil($tabloisim,$kosul) {
		
		return $this->db->sil($tabloisim,$kosul);
		
	}
	
	function Ekleme($tabloisim,$sutunlar,$veriler) {
		
		
		return $this->db->Ekle($tabloisim,$sutunlar,$veriler);
	}
	
	function GirisKontrol($tabloisim,$kosul) {
		
		return $this->db->giriskontrol($tabloisim,$kosul);		
		
	}
	function sayfalama($tabload) {
		
		return $this->db->sayfalamaAdet($tabload);
		
	}
	function tekliveri($sutun,$kosul) {
		
		return $this->db->teklistele($sutun,$kosul);
		
	}
	
	function joinislemi($istenilenveriler,$tablolar,$kosul){
		
		
		return $this->db->joinislemi($istenilenveriler,$tablolar,$kosul);
	}
	
}




?>