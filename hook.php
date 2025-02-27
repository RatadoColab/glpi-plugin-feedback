<?php

/**
 * -------------------------------------------------------------------------
 * feedback plugin for GLPI
 * Copyright (C) 2025 by the feedback Development Team.
 * -------------------------------------------------------------------------
 *
 * MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * --------------------------------------------------------------------------
 */

/**
 * Plugin install process
 *
 * @return boolean
 */
function plugin_feedback_install()
{
    /**
    * @var \DBmysql $DB
    */
    global $DB;

    $res = true;

    $plugin_fields = new Plugin();
    $plugin_fields->getFromDBbyDir('feedback');
    $version = $plugin_fields->fields['version'];
    $migration = new Migration($version);

    /* Version 0.1.0
    *
    *
    */
    $migration->displayMessage(sprintf(__("Installing Feedback %s"), $version));
    $res = $DB->runFile(Plugin::getPhpDir("feedback") . "/install/sql/empty-0.1.0.sql");


    return $res;
}

/**
 * Plugin uninstall process
 *
 * @return boolean
 */
function plugin_feedback_uninstall()
{
    if ($DB->tableExists("glpi_plugin_feedback_messages")) {
        $query = "DROP TABLE `glpi_plugin_feedback_messages`";
        $DB->query($query) or die("error deleting glpi_plugin_feedback_messages");
    }

    return true;
}
