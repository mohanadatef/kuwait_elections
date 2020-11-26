<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Left side column. contains the logo and sidebar -->
        <ul class="sidebar-menu" data-widget="tree">
            @permission('setting-list')
            <li class="treeview">
                <a href="#"><i class="fa fa-group"></i> <span>الأعدادات</span><span class="pull-right-container"><i
                                class="fa fa-angle-right pull-left"></i></span></a>
                <ul class="treeview-menu">
                    @permission('setting-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>الأعدادات</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('setting-index')
                            <li><a href="{{ url('/admin/setting/index') }}"><i
                                            class="fa fa-group"></i><span>قائمة الأعدادات</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('about-us-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>عن الشركة</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('about-us-index')
                            <li><a href="{{ url('/admin/about_us/index') }}"><i
                                            class="fa fa-group"></i><span>عن الشركة</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('privacy-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>الشروط و الاحكام</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('privacy-index')
                            <li><a href="{{ url('/admin/privacy/index') }}"><i
                                            class="fa fa-group"></i><span>الشروط و الاحكام</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('contact-us-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>اتصل بنا</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('contact-us-index')
                            <li><a href="{{ url('/admin/contact_us/index') }}"><i
                                            class="fa fa-group"></i><span>اتصل بنا</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('call-us-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>تواصل معانا</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('call-us-read')
                            <li><a href="{{ url('/admin/call_us/read') }}"><i class="fa fa-group"></i><span>اتصل بنا المقرؤه</span></a>
                            </li>
                            @endpermission
                            @permission('call-us-unread')
                            <li><a href="{{ url('/admin/call_us/unread') }}"><i class="fa fa-group"></i><span>اتصل بنا غير المقرؤه</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('notification-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>الاشعارات</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('notification-index')
                            <li><a href="{{ url('/admin/notification/index') }}"><i
                                            class="fa fa-group"></i><span>قائمة الاشعارات</span></a>
                            </li>
                            @endpermission
                            @permission('notification-create')
                            <li><a href="{{ url('/admin/notification/create') }}"><i
                                            class="fa fa-group"></i><span>اضافة الاشعار</span></a></li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            @permission('acl-list')
            <li class="treeview">
                <a href="#"><i class="fa fa-group"></i> <span>الامان</span><span class="pull-right-container"><i
                                class="fa fa-angle-right pull-left"></i></span></a>
                <ul class="treeview-menu">
                    @permission('user-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>المستخدمين</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('user-index')
                            <li><a href="{{ url('/admin/user/index') }}"><i
                                            class="fa fa-group"></i><span>قائمة المستخدمين</span></a>
                            </li>
                            @endpermission
                            @permission('user-create')
                            <li><a href="{{ url('/admin/user/create') }}"><i
                                            class="fa fa-group"></i><span>اضافة مستخدم</span></a></li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('role-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>نوع المستخدم</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('role-index')
                            <li><a href="{{ url('/admin/role/index') }}"><i
                                            class="fa fa-group"></i><span>قائمة انواع المستخدم</span></a>
                            </li>
                            @endpermission
                            @permission('role-create')
                            <li><a href="{{ url('/admin/role/create') }}"><i
                                            class="fa fa-group"></i><span>اضافه نوع مستخدم</span></a></li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('permission-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>اذنات</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('permission-index')
                            <li><a href="{{ url('/admin/permission/index') }}"><i class="fa fa-group"></i><span>قائمه الاذنات</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('friend-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>الصداقه</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('friend-request')
                            <li><a href="{{ url('/admin/friend/request') }}"><i class="fa fa-group"></i><span>قائمه طلبات الصداقه</span></a>
                            </li>
                            @endpermission
                            @permission('friend-friend')
                            <li><a href="{{ url('/admin/friend/') }}"><i
                                            class="fa fa-group"></i><span>قائمه الاصدقاء</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('log-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>السجل</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('log-index')
                            <li><a href="{{ url('/admin/log/index') }}"><i
                                            class="fa fa-group"></i><span>قائمه السجل</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('takeed-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>الناخبين</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('takeed-index')
                            <li><a href="{{ url('/admin/takeed/index') }}"><i
                                            class="fa fa-group"></i><span>قائمه رفع الناخبين</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            @permission('election-list')
            <li class="treeview">
                <a href="#"><i class="fa fa-group"></i> <span>الانتخابات</span><span class="pull-right-container"><i
                                class="fa fa-angle-right pull-left"></i></span></a>
                <ul class="treeview-menu">
                    @permission('vote-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>الاستبيانات</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('vote-index')
                            <li><a href="{{ url('/admin/vote/index') }}"><i
                                            class="fa fa-group"></i><span>قائمة الاستبيانات</span></a>
                            </li>
                            @endpermission
                            @permission('vote-create')
                            <li><a href="{{ url('/admin/vote/create') }}"><i
                                            class="fa fa-group"></i><span>اضافة اسنتبيان</span></a></li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            @permission('core-data-list')
            <li class="treeview">
                <a href="#"><i class="fa fa-group"></i> <span>بيانات الموقع</span><span class="pull-right-container"><i
                                class="fa fa-angle-right pull-left"></i></span></a>
                <ul class="treeview-menu">
                    @permission('circle-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>الدوائر</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('circle-index')
                            <li><a href="{{ url('/admin/circle/index') }}"><i
                                            class="fa fa-group"></i><span>قائمه الدوائر</span></a>
                            </li>
                            @endpermission
                            @permission('circle-create')
                            <li><a href="{{ url('/admin/circle/create') }}"><i
                                            class="fa fa-group"></i><span>اضافه الدائره</span></a></li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('area-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>المناطق</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('area-index')
                            <li><a href="{{ url('/admin/area/index') }}"><i
                                            class="fa fa-group"></i><span>قائمه المناطق</span></a>
                            </li>
                            @endpermission
                            @permission('area-create')
                            <li><a href="{{ url('/admin/area/create') }}"><i
                                            class="fa fa-group"></i><span>اضافه منطقه</span></a></li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            @permission('social-media-list')
            <li class="treeview">
                <a href="#"><i class="fa fa-group"></i> <span>سوشيال ميديا</span><span class="pull-right-container"><i
                                class="fa fa-angle-right pull-left"></i></span></a>
                <ul class="treeview-menu">
                    @permission('post-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>المنشورات</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('post-index')
                            <li><a href="{{ url('/admin/post/index') }}"><i
                                            class="fa fa-group"></i><span>قائمه المنشورات</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('commit-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>التعليقات</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('commit-index')
                            <li><a href="{{ url('/admin/commit/index') }}"><i
                                            class="fa fa-group"></i><span>قائمه التعليقات</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('like-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>الاعجابات</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('commit-index')
                            <li><a href="{{ url('/admin/like/index') }}"><i
                                            class="fa fa-group"></i><span>قائمه الاعجابات</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    @permission('group-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>الجروبات</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('group-index')
                            <li><a href="{{ url('/admin/group/index') }}"><i
                                            class="fa fa-group"></i><span>قائمه الجروبات</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            @permission('import-list')
            <li class="treeview">
                <a href="#"><i class="fa fa-group"></i> <span>الرفع</span><span class="pull-right-container"><i
                                class="fa fa-angle-right pull-left"></i></span></a>
                <ul class="treeview-menu">
                    @permission('takeed-list')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>الناخبين</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('takeed-form-import')
                            <li><a href="{{ url('/admin/takeed/import/form') }}"><i
                                            class="fa fa-group"></i><span> رفع الناخبين</span></a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
@yield('main-sidebar')
