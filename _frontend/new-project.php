<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main site-content">
            <div class="bg-grey">
                <div class="text-center block-up block">
                    <div class="container">
                        
                        <h1 class="title block block-up">Create New Project</h1>

                        <div class="box box-form box-form--wide block">
                            <form action="" data-validate>
                                <div class="block">
                                    <label for="project-name" class="sr-only">Project Name :</label>
                                    <input id="project-name" class="form-input form-input--block" placeholder="Input Project Name Here ...." type="text" required>
                                </div>

                                <div class="block">
                                    <label for="project-url" class="sr-only">Project URL :</label>
                                    <input id="project-url" class="form-input form-input--block" placeholder="Input Project URL Here ...." type="text" required>
                                </div>

                                <div class="block">
                                    <label for="project-desc" class="sr-only">Project Description :</label>
                                    <textarea id="project-desc" class="form-input form-input--block" placeholder="Input Project Description Here ...." rows="7" required></textarea>
                                </div>

                                <button class="btn btn--primary btn--regular">
                                    Save
                                </button>

                                <a class="btn btn--secondary btn--regular" href="home.php">
                                    Cancel
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>

<?php include '_include/script.php'; ?>