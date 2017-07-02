package model

import "time"

type ArticleEntity struct {
	Id            int       `json:"id"         xorm:"pk autoincr"`
	Title         string    `json:"title"      xorm:"not null"`
	Atype         int       `json:"type"        xorm:"not null"`
	Content       string    `json:"content"     xorm:"not null"`
	Outer_url     string    `json:"outer_url"   xorm:"not null default ''"`
	Visit_url     string    `json:"visit_url"   xorm:"not null default ''"`
	Surface_url   string    `json:"surface_url" xorm:"not null default ''"`
	Abstract      string    `json:"abstract"    xorm:"not null default ''"`
	Status        int       `json:"status"      xorm:"not null default '0'"`
	Remark        string    `json:"remark"      xorm:"not null default ''"`
	View_count    int       `json:"view_count"  xorm:"not null default '0'"`
	Share_count   int       `json:"share_count" xorm:"not null"`
	Favor_count   int       `json:"favor_count" xorm:"not null"`
	Comment_count int       `json:"comment_count" xorm:"not null"`
	Create_time   time.Time `json:"create_time"   xorm:"not null"`
	Last_modified time.Time `json:"last_modified" xorm:"not null"`
	Admin_id      int       `json:"admin_id"   xorm:"not null"`
	Admin_name    string    `json:"admin_name" xorm:"not null default ''"`
}
type Feed struct {
	Id         int64     `json:"feed_id"             xorm:"pk autoincr"`        // primary key
	Name       string    `json:"feed_name"           xorm:"notnull"`            // name of feed
	Alias      *string   `json:"feed_alias"          xorm:"notnull default ''"` // feed name's alias
	FeedUrl    string    `json:"feed_feed_url"       xorm:"notnull unique"`     // url of feed
	Url        string    `json:"feed_url"            xorm:"notnull"`            // url the feed point to
	Desc       string    `json:"feed_desc"           xorm:"notnull default ''"` // feed description
	Type       string    `json:"feed_type"           xorm:"notnull"`            // feed type: rss or atom
	Interval   *int      `json:"feed_interval"       xorm:"notnull default 0"`  // refresh interval (minute), 0 for default interval. value below zero means not update.
	LastFetch  time.Time `json:"feed_last_fetch"     xorm:"notnull"`            // last successful fetch time
	LastFailed time.Time `json:"feed_last_failed"    xorm:"notnull"`            // last failed time for fetching
	LastError  string    `json:"feed_last_error"     xorm:"notnull default ''"` // last error for fetching
	MaxUnread  *uint     `json:"feed_max_unread"     xorm:"notnull default 0"`  // max number of unread items. 0 for keep all.
	MaxKeep    *uint     `json:"feed_max_keep"       xorm:"notnull default 0"`  // max number of items to keep. 0 for keep all, greater than 0 for keep n unread items.
	Filter     *string   `json:"feed_filter"         xorm:"notnull default ''"` // filter. (not to use now)
	UseProxy   int       `json:"feed_use_proxy"      xorm:"notnull default 0"`  // whether to use proxy to fetch feed, 0: try, 1: always, 2: never
	Note       *string   `json:"feed_note"           xorm:"notnull default ''"` // comments for this feed
}
