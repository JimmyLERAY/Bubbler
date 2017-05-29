<?php

//----------------------------------------------------------//
// Calcul et mise à jour des nouvelles positions des bulles //
//----------------------------------------------------------//


$dt = delta_t(); // le pas de temps, très important !
$bubbles = MySQL::select_data('bubbles',array('id'),'');

foreach($bubbles as $bubble){
	$id = $bubble['id'];
    $bulle = ${'B'.$id};

    // Si la bulle n'est pas celle de Bubbler :
    if($id != 72){

        // Ajout des forces de frottements :
        Force::frottement($bulle);

        // Ajout des forces de gravite :
        Force::gravite($bulle);

        // Ajout des forces de répulsion pour éviter les colisions :
        $other_b = MySQL::select_data('bubbles',array('id'),'id!='.$id);
        foreach($other_b as $other_bubble){
            $o_id = $other_bubble['id'];
            $other_bulle = ${'B'.$o_id};

            Force::repulsion($bulle,$other_bulle);

            // Ajout des forces d'attraction entre les bulles :
            if(isset(${'Ls'.$id.'-'.$o_id}) OR isset(${'Ls'.$id.'-'.$o_id})){
                Force::attraction($bulle,$other_bulle);
            }
        }

        // Calcul des accélérations, vitesses, et positions :
        $bulle->set_a($bulle->get_fx()/$bulle->get_mass(),
                    $bulle->get_fy()/$bulle->get_mass());

        $bulle->set_v($bulle->get_vx() + $dt*$bulle->get_ax(),
                    $bulle->get_vy() + $dt*$bulle->get_ay());

        $bulle->set_pos($bulle->get_x() + $dt*$bulle->get_vx(),
                        $bulle->get_y() + $dt*$bulle->get_vy());

    }else{
        
        // Si il s'agit de la bulle de Bubbler :
        $bulle->set_v(0,0);
        $bulle->set_pos(0,0);
    }
    
}