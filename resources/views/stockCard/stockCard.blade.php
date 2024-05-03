<style>
 .vypis td,th,tr,table {
  border: 1px solid black;
  border-collapse: collapse;
}

th {
    font-weight: bold;
}
</style>


<table width="100%">
    <tr>
        <td>
        <img src="../img/logo_svaz_male.png" height="100">    
        
        </td>
        <td>
            
        </td>
        <td>
            <h4>KARTA PŘIDĚLENÉHO MAJETKU</h4>
        </td>
        <td>
            <h4>{{ $lastTransaction?->storage->name }}</h4>
        </td>
    </tr>
</table>
<br>
<span class="vypis">
<table width="100%" >
    <tr></tr>
    <tr align="left" >
        <th width="10%">Inv. č.</td>
        <th width="30%">Název</td>
        <th width="40%">Popis</td>
        <th width="20%">Přiděleno</td>
    </tr>
    @foreach($items as $item) 
    <tr align="left">
        <td>{{ $item->inventory }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->description }}</td>
        <td>{{ $item->lastTransaction->date }}</td>
        
        
        </td>
    </tr>

    
    @endforeach
</table>
</span>
<br>
<p>Reprezentant nebo jeho zákonný zástupce potvrzuje správnost a úplnost informací uvedených na této kartě k datu {{ date(now()) }}. </p>
<br>
<br>
<p>Datum podpisu: .................................... </p>
<br>
<p>Podpis: ........................................... </p>






