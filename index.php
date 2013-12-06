<!DOCTYPE html>

<html>
  <?php include 'src/frame/header.html'; ?>
  <body style="BACKGROUND-IMAGE: url(images/2e_bg.jpg)">
    <div align=center>
      <table style="BORDER-COLLAPSE: collapse" height=576 cellPadding=0 width=990 border=0>
        <tr>
            <td width=230>
                <?php include 'src/frame/left.html'; ?>
            </td>  
            <td>
                <?php 
                    $page = $_GET['page'];
                    $jump_pages =array(
                        'death'  => 'death.php',
                        'about'  => "src/about/index.html",
                        "coopration" => "src/coopration/index.html",
                        "dream" => 'src/dream/index.html'
                    );

                    $final_page = $jump_pages[$page] ;
                    if (is_null($final_page))
                    {
                        include 'src/home/index.html';   
                    } 
                    else
                    {
                        include $final_page;
                    }
                ?>
            </td>
            <td width=85>
                <?php include 'src/frame/right.html'; ?>
            </td>
        </tr>
      </table>
    </div>
  <?php include 'src/frame/footer.html'; ?>
  </body>
</html>
