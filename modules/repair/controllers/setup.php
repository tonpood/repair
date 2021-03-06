<?php
/**
 * @filesource modules/repair/controllers/setup.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Repair\Setup;

use \Kotchasan\Http\Request;
use \Gcms\Login;
use \Kotchasan\Html;
use \Kotchasan\Language;

/**
 * module=repair-setup
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Gcms\Controller
{

  /**
   * ลงทะเบียนสมาชิกใหม่
   *
   * @param Request $request
   * @return string
   */
  public function render(Request $request)
  {
    // ข้อความ title bar
    $this->title = Language::trans('{LNG_List of} {LNG_Repair}');
    // เลือกเมนู
    $this->menu = 'repair';
    // สมาชิก
    $login = Login::isMember();
    // สามารถรับเครื่องซ่อมได้, ช่างซ่อม
    if (Login::checkPermission($login, array('can_received_repair', 'can_repair'))) {
      // แสดงผล
      $section = Html::create('section');
      // breadcrumbs
      $breadcrumbs = $section->add('div', array(
        'class' => 'breadcrumbs'
      ));
      $ul = $breadcrumbs->add('ul');
      $ul->appendChild('<li><span class="icon-tools">{LNG_Repair system}</span></li>');
      $ul->appendChild('<li><span>{LNG_Repair list}</span></li>');
      $section->add('header', array(
        'innerHTML' => '<h2 class="icon-list">'.$this->title.'</h2>'
      ));
      // แสดงฟอร์ม
      $section->appendChild(createClass('Repair\Setup\View')->render($request, $login));
      return $section->render();
    }
    // 404.html
    return \Index\Error\Controller::page404();
  }
}
