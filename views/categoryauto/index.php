<h1>The Tree of Category of Auto</h1>
<ul>
<?php foreach ($results as $categoryauto): ?>
    <li>
        <!--
        <?php echo $categoryauto['t1_id']; ?>
        <?php echo $categoryauto['t1_parent_category_id']; ?>
        <?php echo $categoryauto['t2_id']; ?>
        <?php echo $categoryauto['t2_parent_category_id']; ?>
        <?php echo $categoryauto['parent_name']; ?>
        <?php echo $categoryauto['child_name']; ?>
        -->

        <!--
        <?php echo $categoryauto['id']; ?>
        <?php echo $categoryauto['parent_category_id']; ?>
        <?php echo $categoryauto['name']; ?>
        -->

        <?php echo $categoryauto['chain']; ?>

        <!--
        <?php foreach ($results as $categoryauto_id) {
           if($categoryauto['id']==$categoryauto_id['parent_category_id']) {
              echo $categoryauto_id['name'];
           }
        }  ?>
        -->
    </li>
<?php endforeach; ?>
</ul>

