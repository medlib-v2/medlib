@if (!Auth::guest())
<div id="soc-cont-{{ $counter }}">
    <div id="list-message-{{ $counter }}" style="display: none; margin-top: 10px;">
        <div class="confirm" id="div_list_success">
            <img src="/images/icn_success.gif" alt="" width="16" height="16" class="icon">
            <span id="success-list-link-{{ $counter }}"></span>
        </div>
        <div class="error" id="list-error-{{ $counter }}">
            <strong>Votre liste a atteint le maximum d’ouvrages permis.</strong> Veuillez créer une nouvelle liste avec un nom différent, déplacer des ouvrages dans une autre liste ou supprimer des ouvrages.
        </div>
        <input type="hidden" name="ajax_listid" id="ajax-listid-{{ $counter }}" value="">
    </div>
    <div id="cant-rate-{{ $counter }}" style="display: none; margin-top: 10px;">
        <div class="error" id="cant-rate-msg-{{ $counter }}">
            <img src="/images/icn_list_error.gif" alt="" width="16" height="16" class="icon">
            <span>Vous avez déjà évalué cet ouvrage.</span>
        </div>
    </div>
    <div id="rating-done-{{ $counter }}" style="display: none; margin-top: 10px;">
        <div class="confirm" id="rating-done-msg-{{ $counter }}">
            <img src="/images/icn_success.gif" alt="" width="16" height="16" class="icon">
            <span>Votre évaluation a été enregistrée</span>
        </div>
    </div>
    <div id="soc-links-{{ $counter }}">
        <ul>
            <li><a href="#" class="list" title="">Ajouter à une liste</a></li>
            <li><a href="#" class="tag" title="">Ajouter des tags</a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>
@endif