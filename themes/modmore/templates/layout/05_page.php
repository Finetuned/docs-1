<?php $this->layout('theme::layout/00_layout') ?>


<a href="#sidebar" class="skiplink show-on-focus">Skip to sidebar navigation</a>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<?php if ($params['html']['repo']) {
    ?>
    <a href="https://github.com/<?= $params['html']['repo']; ?>" target="_blank" id="github-ribbon" class="Github hidden-print"><img src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a>
<?php

} ?>


<div class="pagewrapper">
    <div id="pagecontent" class="pagecontent">
        <header class="pageheader">


            <?php if ($config->getHTML()->hasSearch()) { ?>
                <form role='search' action="https://google.com/search" target="_modmoredocsgoogle" method="get" class="Search" id="search_form">
                    <input type="hidden" name="as_sitesearch" value="docs.modmore.com">
                    <label for="search_input">
                        <span class='u-visuallyHidden'>Search</span>
                    </label>
                    <input
                            type="search"
                            id="search_input"
                            class="Search__field"
                            placeholder="<?=$this->translate("Search_placeholder") ?>"
                            aria-label="<?=$this->translate("Search_placeholder") ?>"
                            autocomplete="on"
                            results=25
                            autosave=text_search
                            name="1"
                    >
                    <label>
                        <input type="submit" class='u-visuallyHidden' />
                        <span class='u-visuallyHidden'><?=$this->translate("Search_placeholder") ?></span>
                        <svg class="Search__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451 451">
                            <path d="M447.05 428l-109.6-109.6c29.4-33.8 47.2-77.9 47.2-126.1C384.65 86.2 298.35 0 192.35 0 86.25 0 .05 86.3.05 192.3s86.3 192.3 192.3 192.3c48.2 0 92.3-17.8 126.1-47.2L428.05 447c2.6 2.6 6.1 4 9.5 4s6.9-1.3 9.5-4c5.2-5.2 5.2-13.8 0-19zM26.95 192.3c0-91.2 74.2-165.3 165.3-165.3 91.2 0 165.3 74.2 165.3 165.3s-74.1 165.4-165.3 165.4c-91.1 0-165.3-74.2-165.3-165.4z"/>
                        </svg>
                    </label>
                </form>
            <?php } ?>

            <!-- JavaScript-only search...
                Pros:
                    - Instant result
                    - Offline
                    - Works with the static site generation
                Cons:
                    - Not accessible >:(
                    - Only searches docs, not other modmore content
                    - No tracking

                Use this temporarily, set up something like an elasticsearch server in the future that reads
                out the static content for accessible search capability that also searches site/forums etc.
                Perhaps keep this available one-way or another (check if offline?) for local copies.

                For no-js it falls back to a google search. Better than nothing.
            -->
<!--            <form method="get" action="https://google.com/search" target="_modmoredocsgoogle" class="docsearch" id="search-form">-->
<!--              <label for="tipue_search_input">Search documentation</label>-->
<!--              <input type="search" id="tipue_search_input" name="q" placeholder="Search Documentation">-->
<!--              <input type="hidden" name="as_sitesearch" value="docs.modmore.com">-->
<!--              <button type="submit" class="button"><svg role="presentation"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="--><?php //echo $base_url; ?><!--themes/modmore/dist/sprite.svg#search" title="search"></use></svg></button>-->
<!--            </form>-->
            <script>
                var searchInput = document.getElementById('search_input');
                searchInput.setAttribute('name','query');
                searchInput.parentNode.removeAttribute('action');
                searchInput.parentNode.removeAttribute('target');
                document.querySelector('input[name="as_sitesearch"]').remove();
            </script>
            <div class="headerlinks">
                <a href="https://support.modmore.com/">Contact Support</a>
            </div>
        </header>
        <main class="maincontent" role="main" itemprop="mainContentOfPage">
            <div class="row">
                <div class="column">
                    <div id="tipue_search_content"></div>

                    <?= $this->section('content'); ?>
                </div>
            </div>
        </main>
    </div>
    <aside id="sidebar" class="sidebar">
        <?php
            $rendertree = $tree['en'];
            $path = 'en';

            if ($page['language'] !== '') {
                $rendertree = $tree[$page['language']];
                $path = $page['language'];
            }
        ?>
        <p class="logo">
            <a href="<?php echo $base_url . $path; ?>/index.html" title="modmore documentation"><strong>modmore documentation</strong></a>
        </p>

        <button aria-expanded="false" class="open-nav">
            <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 33 25" class='hamburger'><rect class="cls-1 line-1" width="33" height="3.07"></rect><rect class="cls-1 line-2" y="10.96" width="33" height="3.07"></rect><rect class="cls-1 line-3" y="21.93" width="33" height="3.07"></rect></svg>
            <span class="show-for-sr trigger-status">Open</span> <span class="menu">menu</span>
        </button>

        <nav class="pagenav">
            <?php
            echo $this->get_navigation($rendertree, $path, isset($params['request']) ? $params['request'] : '', $base_page, $params['mode']);
            ?>

        </nav>
    </aside>
</div>
