<footer class="row">
    <hr/>
    <p class="pull-right"><a href="#">{{ t('Back to top') }}</a></p>
    <p>&copy; {{ siteSettings('siteName') }}&nbsp;&middot;&nbsp;
        <a href="{{ route('privacy') }}">{{ t('Privacy Policy') }}</a>&nbsp;&middot;&nbsp;
        <a href="{{ route('tos') }}">{{ t('Terms') }}</a>&nbsp;&middot;&nbsp;
        <a href="{{ route('faq') }}">{{ t('FAQ') }}</a>&nbsp;&middot;&nbsp;
        <a href="{{ route('about') }}">{{ t('About Us') }}</a>&nbsp;&middot;&nbsp;
        <a data-toggle="modal" href="#languageModel">{{ t('Select Language') }}</a>

    <div class="modal fade" id="languageModel" tabindex="-1" role="dialog" aria-labelledby="myLanguageModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Select Language</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $path = app_path().'/lang';
                    $results = scandir($path);
                    foreach ($results as $result) {
                        if ($result === '.' or $result === '..') continue;
                        if (is_dir($path . '/' . $result)) {
                            echo '<p> <a href="'.url('lang/'.$result).'">'.langDecode($result).'</a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </p>
</footer>