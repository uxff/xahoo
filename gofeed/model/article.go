package model

import xorm "github.com/go-xorm/xorm"
import core "github.com/go-xorm/core"
import _ "github.com/mattn/go-sqlite3"
import fmt
import (
	feedreader "../feedreader"
	//global "../global"
)

var Orm *xorm.Engine
var OrmEngine string
var OrmDB string

func FetchUrl(url string) (feed *Feed, items []*ArticleEntity, err error) {

	msgNormally := fmt.Sprintf("[FETCH] Fetch feed '%s' normally", url)
	msgProxy := fmt.Sprintf("[FETCH] Fetch feed '%s' behind proxy", url)
	/*
		if global.UseProxy == global.PROXY_ALWAYS {
			feed, items, err = fetchFeed(url, global.Socks5Fetcher)
			if err != nil {
				global.Logger.Errorf("%s: %s", msgProxy, err.Error())
			} else {
				global.Logger.Infof(msgProxy)
			}
			return
		}
	*/
	feed, items, err = fetchFeed(url, global.NormalFetcher)
	if err == nil {
		global.Logger.Infof(msgNormally)
		return
	}
	/*
		if err != nil {
			global.Logger.Errorf("%s: %s", msgNormally, err.Error())

			if global.UseProxy == global.PROXY_TRY {
				feed, items, err = fetchFeed(url, global.Socks5Fetcher)
				if err != nil {
					global.Logger.Errorf("%s: %s", msgProxy, err.Error())
				} else {
					global.Logger.Infof(msgProxy)
				}
			}
		}
	*/

	return
}

func fetchFeed(url string, fetcher *h.Fetcher) (feed *Feed, items []*ArticleEntity, err error) {
	fd, err := feedreader.Fetch(url, fetcher)
	if err != nil {
		return
	}

	feed, items = assembleFeed(fd)
	return
}

func assembleFeed(fd *feedreader.Feed) (feed *Feed, items []*ArticleEntity) {

	now := time.Now()

	feed = new(Feed)
	feed.Name = fd.Title
	feed.FeedUrl = fd.FeedLink
	feed.Url = fd.Link
	feed.Desc = fd.Description
	feed.Type = fd.Type
	feed.LastFetch = now

	for _, i := range fd.Items {
		var item = new(ArticleEntity)

		if i.Author != nil {
			item.Remark = i.Author.Name
		}

		item.Outer_url = i.Link
		//item.Guid = i.Guid
		item.Title = i.Title
		item.Content = i.Content
		item.Create_time = now

		item.Last_modified = i.PubDate
		if item.Last_modified.IsZero() {
			item.Last_modified = i.Updated
		}

		h := md5.New()
		fmt.Fprint(h, item.Content)
		//item.Hash = fmt.Sprintf("%x", h.Sum(nil))

		items = append(items, item)
	}

	return
}

func SaveArticles(items []*ArticleEntity) (succNum int) {
	var err Error
	OrmDB = "gofeed"
	Orm, err = xorm.NewEngine("sqlite3", OrmDB)
	if err != nil {
		fmt.Println("orm init error:", err)
		return
	}
	Orm.SetMapper(core.SameMapper{})

	session := Orm.NewSession()
	succNum = 0
	for _, item := range items {
		num, e := session.Insert(item)
		if e != nil {
			fmt.Println("insert error:", e)
			continue
		}
		succNum++
	}
}
