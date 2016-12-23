<TabHost
        android:id="@android:id/tabhost"
        android:layout_width="match_parent"
        android:layout_height="match_parent" >

        <LinearLayout
            android:layout_width="match_parent"
            android:layout_height="match_parent"
            android:orientation="vertical" >

            <HorizontalScrollView
                android:id="@+id/h_scroll_view"
                android:layout_width="match_parent"
                android:layout_height="wrap_content"
                android:fillViewport="true"
                android:scrollbars="none" >

                <TabWidget
                    android:id="@android:id/tabs"
                    android:layout_width="match_parent"
                    android:layout_height="wrap_content" >
                </TabWidget>
            </HorizontalScrollView>

            <FrameLayout
                android:id="@android:id/tabcontent"
                android:layout_width="match_parent"
                android:layout_height="match_parent" >

                <android.support.v4.view.ViewPager
                    android:id="@+id/view_pager"
                    android:layout_width="match_parent"
                    android:layout_height="match_parent" >
                </android.support.v4.view.ViewPager>
            </FrameLayout>
        </LinearLayout>
    </TabHost>