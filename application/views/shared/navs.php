
<?php 
  
  if(!isset($nav)){
    $nav = array( 'menu' => '');
  }


  $navsArr = array();
  $navsArr[] =  array( 
                  'label' => 'Home',
                  'link'  => getSiteLink(),
                  'icon'  => 'fa-home'
              );

  $navsArr[] = array( 
                    'label' => 'Classes',
                    'link'  => '#',
                    'icon'  => 'fa-university',
                    'sub-navs' => array(
                                    array(
                                        'label' => 'Classes Management',
                                        'link'  => getSiteLink('classes'),
                                        'icon'  => 'fa-university',
                                    ),
                                )
                );
  if( getRole() == 'teacher' ){
    $navsArr[1]['sub-navs'][] = array(
                                    'label' => "Tasks",
                                    'link'  => getSiteLink('classes/whats-due'),
                                    'icon'  => 'fa-tasks',
                                );
    $navsArr[1]['sub-navs'][] = array(
                                    'label' => "Gradebook",
                                    'link'  => getSiteLink('classes/gradebook'),
                                    'icon'  => 'fa-table',
                                );
  }else{
    $navsArr[1]['sub-navs'][] = array(
                                    'label' => "Progress",
                                    'link'  => getSiteLink('progress'),
                                    'icon'  => 'fa-table',
                                );

    $navsArr[] = array(
                      'label'=> 'Tasks',
                      'icon' => 'fa-tasks',
                      'link'  => getSiteLink('tasks')
    );
  }

  $navsArr[] =  array( 
      'label' =>  'Multimedia',
      'link'  => getSiteLink('activities'),
      'icon'  => 'fa-gamepad'
  );


  $navsArr[] =  array( 
                    'label' =>  getRole() == 'teacher' ? 'Library' : 'Backpack',
                    'link'  => getSiteLink('library'),
                    'icon'  => 'fa-book'
                );

  $navsArr[] = array( 
                  'label' => 'Messages',
                  'link'  => getSiteLink('messages'),
                  'icon'  => 'fa-envelope'
              );
 ?>




<nav class="navbar navbar-expand-lg p-0"> 
  <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"> <i class="fa fa-bars m-auto"></i> </span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">


      <?php foreach ($navsArr as $navItem) : ?>

        <li class="nav-item <?= $nav['menu'] == $navItem['label'] ? 'active' : '';?> <?= isset($navItem['sub-navs']) ? 'dropdown' : ''; ?>">
          <a class="nav-link" href="<?=$navItem['link'] ?>" <?= isset($navItem['sub-navs']) ? 'data-toggle="dropdown"' : ''; ?>>
            <i class="fa <?=$navItem['icon'] ?>"></i>  <?=$navItem['label']  ?>
          </a>

          <?php if( isset($navItem['sub-navs']) ): ?>
              <ul class="dropdown-menu">
              <?php foreach ($navItem['sub-navs'] as $navSubItem) : ?>
                  <li class="<?= 
                                isset($nav['sub-menu']) && $nav['sub-menu'] == '' ||
                                isset($nav['sub-menu']) && $nav['sub-menu'] == $navSubItem['label'] ? 'active' :  '';?> "> 
                      <a href="<?=$navSubItem['link']?>"> <?= $navSubItem['label']; ?>  </a>
                  </li>    
              <?php endforeach;?>
              </ul>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</nav>