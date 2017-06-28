package model

import "time"

type ArticleEntity struct {
	id            int       `json:"id"         xorm:"pk autoincr"`
	title         string    `json:"title"      xorm:"title"`
	atype         int       `json:"type"        xorm:"type"`
	content       string    `json:"content"     xorm:"content"`
	outer_url     string    `json:"outer_url"   xorm:"outer_url"`
	visit_url     string    `json:"visit_url"   xorm:"visit_url"`
	surface_url   string    `json:"surface_url" xorm:"surface_url"`
	abstract      string    `json:"abstract"    xorm:"abstract"`
	status        int       `json:"status"      xorm:"status"`
	remark        string    `json:"remark"      xorm:"remark"`
	view_count    int       `json:"view_count"  xorm:"view_count"`
	share_count   int       `json:"share_count" xorm:"share_count"`
	favor_count   int       `json:"favor_count" xorm:"favor_count"`
	comment_count int       `json:"comment_count" xorm:"comment_count"`
	create_time   time.Time `json:"create_time"   xorm:"create_time"`
	last_modified time.Time `json:"last_modified" xorm:"last_modified"`
	admin_id      int       `json:"admin_id"   xorm:"admin_id"`
	admin_name    string    `json:"admin_name" xorm:"admin_name"`
}
