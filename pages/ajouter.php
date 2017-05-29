<?php
	// Chargement des prérequis à toute requête PHP :
	require '../models/required.php';
?>

<div id="page_container" data-ng-controller="AjouterCtrl">
	<div class="container">
		<div id="loginbox" class="mainbox col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">                    
			<div class="panel panel-info">

				<div class="panel-heading">
					<div class="panel-title">Créer vos propres liens et bulles</div>
					<span class="pull-right clickable glyphicon glyphicon-remove" data-ng-click="close_window()"></span>
				</div>

				<div style="padding-top:20px" class="panel-body" >

					<form id="ajouterform" class="form-horizontal" name="ajouterform" role="form" novalidate>

						<div class="alert alert-success col-sm-12" data-ng-hide="help" data-ng-click="toggle_help()" style="cursor:pointer;">
							<b><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Besoin d'aide ou de conseils ?</b>
						</div>
						<div class="alert alert-success col-sm-12" data-ng-show="help" data-ng-click="toggle_help()" style="cursor:pointer;">
							<b>Pour créer un lien</b>, vous pouvez indiquer le <b>nom de deux bulles</b>. Le lien peut-être entre des bulles qui <b>existent déjà ou non</b>. N'oubliez pas que chaque bulle doit représenter <b>un seul concept</b>. Pour lier votre bulle personelle à une autre, utilisez <b>votre pseudonyme</b>.
						</div>

						<div class="form-group">
                            <label for="bulle1" class="col-md-3 control-label">Première bulle</label>
                            <div class="col-md-9">
                                <input id="bulle1" type="text" class="form-control" name="bulle1" data-ng-model="bulle1" placeholder="Nom de la première bulle" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bulle2" class="col-md-3 control-label">Deuxième bulle</label>
                            <div class="col-md-9">
                                <input id="bulle2" type="text" class="form-control" name="bulle2" data-ng-model="bulle2" placeholder="Nom de la deuxième bulle" required>
                            </div>
                        </div>

                        <!--<div class="form-group">
                            <label for="intensite" class="col-md-3 control-label">Interaction</label>
                            <div class="col-md-9">
                                <label class="radio-inline"><input type="radio" name="intensite" value="attraction" data-ng-model="intensite">Attraction</label>
                                <label class="radio-inline"><input type="radio" name="intensite" value="repulsion" data-ng-model="intensite">Répulsion</label>
                            </div>
                        </div>-->

						<div style="margin-top:20px;margin-bottom:5px;" class="form-group">
							<!-- Button -->
							<div class="col-sm-12 controls">
								<div class="ui-group-buttons">
									<input type="submit" class="btn btn-info" value="Confirmer" data-ng-click="ajouter()" data-ng-disabled="bulle1 == '' || bulle2 == ''">
								</div>
							</div>
						</div>

						<div class="alert alert-success col-sm-12" data-ng-show="add" style="margin-top:10px;margin-bottom:0px;">
							<ul>
								<li>
									Votre lien a bien été ajouté !
								</li>
							</ul>
						</div>

						<div class="alert alert-warning col-sm-12" data-ng-show="bulle1 == '' || bulle2 == ''" style="margin-top:10px;margin-bottom:0px;">
							<ul>
								<li>
									Précisez le nom des bulles
								</li>
							</ul>
						</div>

						<div class="alert alert-danger col-sm-12" data-ng-show="already || notallowed" style="margin-top:10px;margin-bottom:0px;">
							<ul>
								<li data-ng-show="already">
									Ce lien est déjà enregistré
								</li>
								<li data-ng-show="notallowed">
									Vous ne pouvez pas lier ces bulles
								</li>
							</ul>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
