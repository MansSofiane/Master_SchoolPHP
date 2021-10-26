<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
$id_user = $_SESSION['id_user'];
//+'&ri='+mtt_reg_i+'&cpl='+mtt_cpl+'&dt='+mtt_dt
if ( isset($_REQUEST['code']) && isset($_REQUEST['mode']) && isset($_REQUEST['agence'])  ){
    $code = $_REQUEST['code'];
    $mode = $_REQUEST['mode'];
    $agence = $_REQUEST['agence'];
    $police = $_REQUEST['p'];
    $type=$_REQUEST['t'];//si type=0 police sinon avenant.

    $libmpay="--";
    $dateop=$_REQUEST['dateop'];
    $libmpay=addslashes($_REQUEST['libmpay']);
    $montant=$_REQUEST['mtt'];
    $solde=$_REQUEST['s'];
    $sens=$_REQUEST['dir'];
    $montant_reg_init=$_REQUEST['ri'];
    $montant_cpl=$_REQUEST['cpl'];
    $montant_dt=$_REQUEST['dt'];

    if($montant_reg_init>0)
    {
        $montant_cpl=0;// pour gerer l etat des encaissement les cout de police sont deja encaisse
        $montant_dt=0;
        $base_pn_commission=$montant;
        $base_primcom_commission=$montant;
        if ($sens=='50' || $sens=='30' )//prime nette (-pn-cout de police - droit de timbre)
        {

            $base_pn_commission = -$montant;
            $base_primcom_commission = -$montant;
            $montant=-$montant;
            $solde=-$solde;
        }
    }
    else {
        if ($sens=='50')//avenant sans ristourne
        {
            $montant_dt=-$montant_dt;
            $montant_cpl=-$montant_cpl;
            $montant=-$montant;

            $solde=-$solde;

            $base_pn_commission = $montant - $montant_cpl - $montant_dt;
            $base_primcom_commission = $montant - $montant_dt;




        }else {
            if ($sens=='30')//avenant avec ristourne
            {
                $montant=-$montant;
                $solde=-$solde;
                $base_pn_commission = $montant - $montant_cpl - $montant_dt;
                $base_primcom_commission = $montant - $montant_dt;


            }else // production positive
            {
                $base_pn_commission = $montant - $montant_cpl - $montant_dt;
                $base_primcom_commission = $montant - $montant_dt;
            }
        }
    }

    $datesys=date("y-m-d H:i:s");
    $seq_avis="";
    $seq_avis_dep="";
    $quittance="";
    try {
        $bdd->beginTransaction();
        $rqtseq = $bdd->prepare("SELECT distinct sequence_avis,sequence_avis_dep FROM `sequence_ag` where cod_agence='$agence' ");
        $rqtseq->execute();
        while ($rwsq_avis = $rqtseq->fetch()) {
            $seq_avis = $rwsq_avis['sequence_avis'];
            $seq_avis_dep = $rwsq_avis['sequence_avis_dep'];
        }
        $seq_avis = $seq_avis + 1;
        $seq_avis_dep = $seq_avis_dep + 1;

        if($type==0)//on regle une police
        $rqtseqq = $bdd->prepare("SELECT distinct `id_quit` FROM `quittance` where cod_ref='$code' and type_quit=0 ");//cas police
        else
            if($sens!='30' && $sens!='50')
            $rqtseqq = $bdd->prepare("SELECT distinct `id_quit` FROM `quittance` where cod_ref='$code' and type_quit=1 and sens='0'");//cas avenant positif.
            else
                $rqtseqq = $bdd->prepare("SELECT distinct `id_quit` FROM `quittance` where cod_ref='$code' and type_quit=1 and sens='1'");//cas avenant positif.
        $rqtseqq->execute();
        while ($rwsq_q = $rqtseqq->fetch()) {
            $quittance = $rwsq_q['id_quit'];
        }

        if($type==0)
        $rqt = $bdd -> prepare("INSERT INTO `avis_recette`( `cod_avis`, `cod_quit`, `cod_ref`,`cod_av`, `dat_avis`, `cod_mpay`, `lib_mpay`, `dat_mpay`, `mtt_avis`,`mtt_solde`,`base_pn_commission`, `base_primcom_commission`, `mtt_cpl`, `mtt_dt`,`id_user`, `type_avis`,`sens_avis`)
                                                  VALUES ('$seq_avis','$quittance','$code','0','$datesys','$mode','$libmpay','$dateop','$montant','$solde','$base_pn_commission','$base_primcom_commission','$montant_cpl','$montant_dt','$id_user','0','0')");
       else
           if($sens!='30' && $sens!='50')
           $rqt = $bdd -> prepare("INSERT INTO `avis_recette`( `cod_avis`, `cod_quit`, `cod_ref`,`cod_av`, `dat_avis`, `cod_mpay`, `lib_mpay`, `dat_mpay`, `mtt_avis`,`mtt_solde`,`base_pn_commission`, `base_primcom_commission`, `mtt_cpl`, `mtt_dt`, `id_user`, `type_avis`,`sens_avis`)
                                                  VALUES ('$seq_avis','$quittance','$police','$code','$datesys','$mode','$libmpay','$dateop','$montant','$solde','$base_pn_commission','$base_primcom_commission','$montant_cpl','$montant_dt','$id_user','1','0')");
           else
           $rqt = $bdd -> prepare("INSERT INTO `avis_recette`( `cod_avis`, `cod_quit`, `cod_ref`,`cod_av`, `dat_avis`, `cod_mpay`, `lib_mpay`, `dat_mpay`, `mtt_avis`,`mtt_solde`,`base_pn_commission`, `base_primcom_commission`, `mtt_cpl`, `mtt_dt`, `id_user`, `type_avis`,`sens_avis`)
                                                  VALUES ('$seq_avis_dep','$quittance','$police','$code','$datesys','$mode','$libmpay','$dateop','$montant','$solde','$base_pn_commission','$base_primcom_commission','$montant_cpl','$montant_dt','$id_user','1','1')");


        $rqt->execute();

        $rqt2 = $bdd->prepare("update `quittance` set solde_pol='$solde' where id_quit='$quittance'");
        $rqt2->execute();
        if($sens!='30' && $sens!='50')

        $rqt3 = $bdd->prepare("update `sequence_ag` set sequence_avis=$seq_avis where cod_agence='$agence'");
        ELSE
        $rqt3 = $bdd->prepare("update `sequence_ag` set sequence_avis_dep=$seq_avis_dep where cod_agence='$agence'");

        $rqt3->execute();
        if($type==0)
        $rqt4 = $bdd->prepare("update policew set mtt_solde='$solde',mtt_reg=mtt_reg+$montant where cod_pol='$code'");
        else
            if($sens!='30' && $sens!='50')
            $rqt4 = $bdd->prepare("update avenantw set mtt_solde='$solde',mtt_reg=mtt_reg+$montant where cod_av='$code'");
            else
                $rqt4 = $bdd->prepare("update avenantw set mtt_solde='$solde',mtt_reg=mtt_reg+$montant where cod_av='$code'");
        $rqt4->execute();
        $bdd->commit();
        echo '0';
    }
    catch(Exception $e){
        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        echo $e->getMessage();
        //Rollback the transaction.
        $bdd->rollBack();
    }

}
?>