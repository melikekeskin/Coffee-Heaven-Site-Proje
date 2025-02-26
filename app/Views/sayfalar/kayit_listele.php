<table class="table">
  <thead>
    <tr>
    <th scope="col">#</th>
      <th scope="col">Ürün Adı</th>
      <th scope="col">Url</th>
      <th scope="col">Üürn Fiyatı</th>
      <th scope="col">İşlem</th>
    </tr>
  </thead>
  <tbody>
    <?php

if (isset($kayitlar) && count($kayitlar) > 0) 
{
  foreach ($kayitlar as $item) 
  {
    echo' <tr>';
    echo '<th scope="row">'.$item['id'].'</th>';
    echo '<td>'.$item['urunAdi'].'</td>';
    echo '<td>'.$item['url'].'</td>';
    echo '<td>'.$item['urunFiyati'].'</td>';
    echo'<td>';
    echo'<a href="'.base_url('kayit_sil/'.$item['id']).'" class="btn btn-outline-danger">Sil</a>';
    echo'<a href="'.base_url('kayit_duzenle/'.$item['id']).'" class="btn btn-outline-warning">düzenle</a>';
    echo'</td>';
    echo' </tr>';
  }

}
else 
{
  echo '<p>Gösterilecek veri bulunamadı.</p>';
}
?>   
</tbody>

</table>