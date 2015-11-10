<?php

if(class_exists(NzWpOptionsPageInterface)){
    return;
}

interface NzWpOptionsPageInterface
{
    /* public function __construct($menu_title, $capability, $menu_slug); */

    /**
     *     
     */
    public function mainMenu();

    public function mainPage();
}

abstract class NzWpOptionsPageAbstract
{
    /**
     *  Page title & Menu title
     */
    private $menu_title;

    /**
     *  Capability
     */
    private $capability;

    /**
     *  page slug
     */
    private $menu_slug;

    /**
     *  page method reference
     */
    private $methods;

    /**
     *  current submenu count
     */
    private $current = 0;

    public function __construct($menu_title, $capability, $menu_slug)
    {
        $this->menu_title = $menu_title;
        $this->capability = $capability;
        $this->menu_slug = $menu_slug;

        add_action('admin_menu', array($this, 'add_menu'));

        $this->methods = [];
    }

    protected function addNotice($notice)
    {
        ?>
        <div class="updated">
            <p><?php echo $notice ?></p>
        </div>
        <?php
    }

    public function runMainPage()
    {
        ?>
        <div class="wrap">
            <?php
            /* $get = $_GET; */
            $p_mtd = '';
            foreach ($_GET as $pid => $method) {
                if (!preg_match('/^pid\d+/', $pid)) {
                    continue;
                }

                $this->methods[] = $method;
                $p_mtd .= $method . '_';
            }
            $page_method = rtrim($p_mtd, '_');
            /* d($page_method); */
            $this->mainMenu();

            //submenu
            $submenu = '';
            foreach ($this->methods as $method) {
                $submenu .= '_' . $method . 'Submenu';
                $submenu = ltrim($submenu, '_');
                $this->callMenuFunction($submenu, "<hr>");
                $submenu = rtrim($submenu, 'Submenu');
            }

            if (empty($page_method)) {
                $this->mainPage();
            } else if (method_exists($this, $page_method)) {
                $this->$page_method();
            } else {
                echo sprintf('page { %s } does no exist', $page_method);
            }
            ?>
        </div>
        <?php
    }

    private function callMenuFunction($menu, $sep = '')
    {
        /* d($menu); */
        if (method_exists($this, $menu)) {
            echo '<div>';
            echo $sep;
            $this->current++;
            $this->$menu();
            echo '</div>';
        }
    }

    public function add_menu()
    {
        add_options_page($this->menu_title, $this->menu_title, $this->capability, $this->menu_slug, array($this, 'runMainPage'));
    }

    protected function menuItem($name, $method)
    {

        $url = $this->pageUrl($method);

        //apply active class on menu items
        $class = (in_array($method, $this->methods)) ? 'button-primary' : 'button';
        echo '<a class="' . $class . '" href="' . $url . '">' . $name . '</a>&nbsp;';
    }

    protected function pageUrl($method, $query_args = array())
    {
        //build query args
        $args = [];
        for ($i = 0; $i < $this->current; $i++) {
            $id = 'pid' . $i;
            /* if (isset($this->methods[$i])) { */
            $args[$id] = $this->methods[$i];
            /* } */
        }

        $id = 'pid' . $this->current;
        $args[$id] = $method;
        $args = array_merge($args, $query_args);

        $base_url = admin_url("options-general.php?page=" . $this->menu_slug);
        $url = add_query_arg($args, $base_url);

        return $url;
    }

    protected function buildTable($items, $title = null, $customs = [])
    {

        if (isset($title)) {
            ?>
            <p>
                <strong>
                    <?php echo $title ?>
                </strong>
                <br>
                total : <?php echo count($items) ?>
            </p>
            <?php
        }
        if (empty($items)) {
            echo '<p>[XXX]</p>';
            return;
        }
        ?>
        <table class="widefat">
            <thead>
                <?php
                $this->_table_header($items, $customs);
                ?>
            </thead>
            <tbody>
                <?php
                $this->_table_body($items, $customs);
                ?>
            </tbody>
        </table>

        <?php
        //sub menu
    }

    private function _table_header($items, $customs = [])
    {

        $first = reset($items);
        if (is_object($first)) {

            $vars = get_object_vars($first);
            $keys = array_keys($vars);
        } else {

            $keys = (isset($items[0])) ?
                array_keys($items[0]) : array_keys($items);
        }
        ?>
        <tr>
            
            <?php
            /*d($keys);*/
            $keys = (is_array($keys))? $keys : array($keys);
            $keys = array_merge(array_keys($customs), $keys);
            foreach ($keys as $key) {
                ?>
                <th><?php esc_attr_e($key, 'wp_admin_style'); ?></th>
                <?php
            }
            ?>
        </tr>
        <?php
    }

    private function _table_body($items, $customs = [])
    {

        if (is_object(reset($items))) {
            foreach ($items as $item) {
                $vars = get_object_vars($item);
                $values = array_values($vars);
                ?>
                <tr>
                    <?php
                    $this->_table_customs($vars, $customs);
                    foreach ($values as $value) {
                        $this->_table_division($value);
                    }
                    ?>
                </tr>
                <?php
            }
        } else {


            if (
                array_key_exists(0, $items)
            /*                isset($items[0]) */
            /* && is_array($items[0]) */
            ) {
                foreach ($items as $item) {
                    ?>
                    <tr>
                        <?php
                        $this->_table_customs($item, $customs);
                        
                        $item = (is_array($item))?$item: array($item);
                        $keys = array_keys($item);
                        foreach ($keys as $key) {
                            $this->_table_division($item[$key]);
                        }
                        ?>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <?php
                    foreach ($items as $item) {
                        $this->_table_customs($item, $customs);
                        $this->_table_division($item);
                    }
                    ?>
                </tr>
                <?php
            }
        }
    }

    private function _table_division($item)
    {
        echo "<td>";

        if (is_object($item) || is_array($item)) {
            $this->buildTable($item);
        } else if (empty($item)) {
            echo '---';
        } else {
            echo $item;
        }
        echo '</td>';
    }

    private function _table_customs($item, $customs)
    {
        $values = array_values($customs);
        foreach ($values as $value) {
            preg_match('/\{\w+\}/', $value, $matches);
            foreach ($matches as $match) {
                $key = str_replace(['{', '}'], '', $match);
                if (isset($item[$key])) {
                    /* d($item[$key]); */
                    $replace = urlencode($item[$key]);
                    /*$replace = $item[$key];*/
                    /* d($replace); */
                    /* d(urldecode($replace)); */
                    $value = str_replace($match, $replace, $value);
                    /* d($value); */
                }
            }
            /* $value = htmlentities($value); */
            /* d($value); */
            $this->_table_division($value);
        }
    }
}
