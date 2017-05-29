<div id="page_container" data-ng-controller="InscriptionCtrl">
    <div class="container">
        <div id="signupbox" class="mainbox col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="panel panel-info">

                <div class="panel-heading">
                    <div class="panel-title">Inscription</div>
                    <span class="pull-right clickable glyphicon glyphicon-remove" data-ng-click="close_window()"></span>
                </div>  

                <div class="panel-body">
                    <form id="signupform" class="form-horizontal" name="signupform" role="form" novalidate>

                        <div class="form-group">
                            <label for="pseudo" class="col-md-3 control-label">Pseudo</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="pseudo" data-ng-model="pseudo" placeholder="Votre pseudonyme" required>
                            </div>
                            <label for="sexe" class="col-md-3 control-label">Sexe</label>
                            <div class="col-md-9">
                                <label class="radio-inline"><input type="radio" name="sexe" value="masculin" data-ng-model="sexe"><span class="fa fa-mars"></span> Homme</label>
                                <label class="radio-inline"><input type="radio" name="sexe" value="feminin" data-ng-model="sexe"><span class="fa fa-venus"></span> Femme</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="email" data-ng-model="email" placeholder="Votre adresse email" required>
                                <input type="email" class="form-control" name="emailbis" data-ng-model="emailbis" placeholder="Confirmez votre email" style="margin-top:5px;" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-5 control-label">Mot de passe</label>
                            <div class="col-md-7">
                                <input type="password" class="form-control" name="password" data-ng-model="password" placeholder="Votre mot de passe" required>
                                <input type="password" class="form-control" name="passwordbis" data-ng-model="passwordbis" placeholder="Confirmez le" style="margin-top:5px;" required>
                            </div>
                        </div>

                        <div style="margin-top:20px" class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <div class="ui-group-buttons" style="float:right;">
                                    <input type="submit" class="btn btn-info" value="S'inscrire" data-ng-click="inscription()" data-ng-disabled="(signupform.email.$dirty && signupform.email.$invalid) || (signupform.password.$dirty && signupform.password.$invalid) || (signupform.pseudo.$dirty && signupform.pseudo.$invalid) || (email != emailbis) || (password != passwordbis)">
                                    <!--<div class="or"></div>
                                    <input type="submit" class="btn btn-primary disabled" value="avec Facebook">
                                    -->
                                </div>
                            </div>
                        </div>

                        <div id="signup-danger" class="alert alert-danger col-sm-12" data-ng-show="wrong_email || wrong_pseudo || (email != emailbis) || (password != passwordbis)">
                            <ul>
                                <li data-ng-show="wrong_pseudo">
                                    Ce pseudonyme est déjà utilisé
                                </li>
                                <li data-ng-show="wrong_email">
                                    Cet email est déjà utilisé
                                </li>
                                <li data-ng-show="email != emailbis">
                                    Vérifiez votre email
                                </li>
                                <li data-ng-show="password != passwordbis">
                                    Vérifiez votre mot de passe
                                </li>
                            </ul>
                        </div>

                        <div id="signup-warning" class="alert alert-warning col-sm-12" data-ng-show="(signupform.email.$dirty && signupform.email.$invalid) || (signupform.password.$dirty && signupform.password.$invalid) || (signupform.pseudo.$dirty && signupform.pseudo.$invalid)">
                            <ul data-ng-show="signupform.email.$dirty && signupform.email.$invalid">
                                <li data-ng-show="signupform.email.$error.required">
                                    Adresse mail requise
                                </li>
                                <li data-ng-show="signupform.email.$error.email">
                                    Adresse mail invalide
                                </li>
                            </ul>
                            <ul data-ng-show="signupform.pseudo.$dirty && signupform.pseudo.$invalid">
                                <li data-ng-show="signupform.pseudo.$error.required">
                                    Pseudonyme requis
                                </li>
                            </ul>
                            <ul data-ng-show="signupform.password.$dirty && signupform.password.$invalid">
                                <li data-ng-show="signupform.password.$error.required">
                                    Mot de passe requis
                                </li>
                            </ul>
                        </div>

                        <div class="form-group" style="margin-bottom:0px;">
                            <div class="col-md-12 control">
                                <div style="font-size:85%" >
                                    Vous allez recevoir un <b>email</b> contenant une clé de sécurité pour <b>activer votre compte</b> Bubbler.
                                </div>
                            </div>
                        </div>        
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>
