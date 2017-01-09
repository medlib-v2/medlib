@if(!empty($result->notes))
<div class="notes" id="notes-{{ $counter }}">
    <table border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td>
                    <span class="item-notes">Sujets&nbsp;:&nbsp;</span></td>
                <td>
                    <ul id="subject-terms" class="theme">
                    @foreach ($result->notes as $note)
                          <li class="subject-term">
                              <a href="#" lang="en" title="Voir tous les ouvrages sur le sujet '{{ $note }}'">{{ $note }}</a>
                          </li>
                    @endforeach
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif