<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main site-content block-up">
            <div class="bg-grey block">
                <div class="container">
                    <form class="search" action="">
                        <span class="fa fa-search"></span>
                        <label for="search-user" class="search__label sr-only">Search User : </label>
                        <input id="search-user" class="search__input form-input" type="text" placeholder="search user...">
                    </form>
                </div>
            </div>

            <div class="container block-up">
                <h1 class="title">Manage User</h1>
                <div class="bzg">
                    <div class="bzg_c" data-col="s12,m6,l4">
                        <a href="new-account.php">
                            <div class="box-newuser block">
                                <span class="fa fa-plus"></span>
                                <span>Create New Account</span>
                            </div>
                        </a>
                    </div>

                    <?php for ($i=0; $i < 10; $i++) { ?>
                        <div class="bzg_c block" data-col="s12,m6,l4">
                            <div class="box box--block cf" href="project.php">
                                <div class="box__thumbnail">
                                    <span class="text-big">
                                        CT
                                    </span>
                                </div>
                                <div class="box__desc text-ellipsis">
                                    <b>Christine Teoriman</b> <br>
                                    <span>christine.teoriman@gmail.com</span> <br>
                                    <select name="" id="">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <a class="box__close" href="">
                                    <span class="fa fa-times"></span>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    
                </div>
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>

<?php include '_include/script.php'; ?>
