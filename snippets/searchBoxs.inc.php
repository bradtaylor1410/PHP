<?PHP

echo'<div class="searchData" id="searchBoxesContainer">';
  echo'<div id="searchBoxesOuter">';
    echo'<div class="title">SEARCH PROPERTY</div>';
      echo'<div id="searchBoxesInner">';

          $showing = 'For Sale or Lease';
          if(isset($_REQUEST["cat"]) and isset($cats[$_REQUEST["cat"]])){
            $showing = $cats[$_REQUEST["cat"]];
          }
          echo'<div class="clear custom-select" id="category"><span>'.$showing.'</span><i class="fas fa-chevron-down"></i><options>';
          foreach($cats as $id => $c){
            $active='';
            if(isset($_REQUEST["cat"]) and $id == $_REQUEST["cat"]){
              $active = 'active';
            }
            echo'<pick data-value="'.$id.'" class="'.$active.'">'.$c.'</pick>';
          }
          echo'</options></div>';

          $locations=array();
          if(isset($_REQUEST["location"])){

            $locations=explode(',',$_REQUEST["location"]);
            $showing = $postcodes[reset($locations)];
            if(count($locations) > 1){
              $showing.=' + '.(count($locations) -1).' More';
            }

          }else{

            $showing = 'Any Location - or search by postcode';

          }
          echo '<div class="custom-select multi" id="location"><span>'.$showing.'</span><i class="fas fa-chevron-down"></i><options>';
          foreach($postcodes as $id => $postcode){
            $checked ='';
            if(in_array($id,$locations)){
              $checked = 'checked';
            }
            echo'<pick data-value="'.$id.'"><label class="checkContainer"><t>'.$postcode.' '.$id.'</t><input type="checkbox" '.$checked.'><span class="checkmark"></span></label></pick>';
          }

          echo'</options></div>';

          $property_types=array();
          if(isset($_REQUEST["property_type"])){
            $property_types=explode(',',$_REQUEST["property_type"]);
            $show = $propertyTypes[reset($property_types)];
            if(count($property_types) > 1){
              $show.=' + '.(count($property_types) -1).' More';
            }
          }else{
            $show = 'Any Property Types';
          }

          echo '<div class="custom-select multi" id="property_type">
          <span>'.$show.'</span><i class="fas fa-chevron-down"></i>
          <options>
              <pick data-value="0">Any Property Type</pick>';
              foreach($propertyTypes as $id => $pts){
                $checked ='';
                if(in_array($id,$property_types)){
                  $checked = 'checked';
                }
                echo'<pick data-value="'.$id.'"><label class="checkContainer"><t>'.$pts.'</t><input type="checkbox" '.$checked.'><span class="checkmark"></span></label></pick>';
              }
          echo'</options>
          </div>';

          $showing = 'Any Price';
          if(isset($_REQUEST["price"]) and isset($pricerange[$_REQUEST["price"]])){
            $showing = $pricerange[$_REQUEST["price"]];
          }
          echo '<div class="custom-select" id="Price">
          <span>'.$showing.'</span><i class="fas fa-chevron-down"></i>
            <options>
              <pick data-value="0">Any Price</pick>';
              foreach($pricerange as $id => $price){
                $active='';
                if(isset($_REQUEST["price"]) and $id == $_REQUEST["price"]){
                  $active = 'active';
                }
                echo'<pick data-value="'.$id.'" class="'.$active.'">'.$price.'</pick>';
              }
            echo'</options>
          </div>';



          $showing = 'Any Floor Size';
          if(isset($_REQUEST["floorArea"]) and isset($floorarea[$_REQUEST["floorArea"]])){
            $showing = $floorarea[$_REQUEST["floorArea"]];
          }
          echo '<div class="custom-select" id="Floor_area">
          <span>'.$showing.'</span><i class="fas fa-chevron-down"></i>
            <options>
              <pick data-value="0">Any Floor Size</pick>';
              foreach($floorarea as $id => $area){
                $active='';
                if(isset($_REQUEST["floorArea"]) and $id == $_REQUEST["floorArea"]){
                  $active = 'active';
                }
                echo'<pick data-value="'.$id.'" class="'.$active.'">'.$area.'</pick>';
              }
            echo'</options>
          </div>';

      echo'</div>';
    echo'<div class="button" id="search">SEARCH</div>';
  echo'</div>';
echo'</div>';
