package model

import xorm "github.com/go-xorm/xorm"
import core "github.com/go-xorm/core"

//import _ "github.com/mattn/go-sqlite3"
import h "github.com/m3ng9i/go-utils/http"

//import "crypto/md5"
import "time"
import _ "github.com/go-sql-driver/mysql"
import "fmt"
import (
	feedreader "../feedreader"
	//global "../global"
)

var Orm *xorm.Engine
var OrmEngine string
var OrmDB string
var NormalFetcher *h.Fetcher

func FetchUrl(url string) (feed *Feed, items []*ArticleEntity, err error) {

	headers := make(map[string]string)
	headers["User-Agent"] = "QReader or SomeAnonymous Spider" //"Mozilla/5.0(Macintosh;U;IntelMacOSX10_6_8;en-us)AppleWebKit/534.50(KHTML,likeGecko)Version/5.1Safari/534.50" //fmt.Sprintf("QReader %s (%s)", Version.Version, Github)

	NormalFetcher = h.NewFetcher(nil, headers)

	//msgNormally := fmt.Sprintf("[FETCH] Fetch feed '%s' normally", url)
	//msgProxy := fmt.Sprintf("[FETCH] Fetch feed '%s' behind proxy", url)
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
	feed, items, err = fetchFeed(url, NormalFetcher)
	if err != nil {
		fmt.Println("feed error:", err)
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
		// save as article
		var item = new(ArticleEntity)

		if i.Author != nil {
			item.Remark = i.Author.Name
		}

		item.Outer_url = i.Link
		//item.Guid = i.Guid
		item.Title = i.Title
		item.Content = i.Content
		rs := []rune(i.Content)
		item.Abstract = string(rs[:200])
		item.Create_time = now
		item.Last_modified = now
		item.Status = 2
		if len(i.ImgLinks) > 0 {
			item.Surface_url = *i.ImgLinks[0]
		}

		item.Pubdate = i.PubDate
		/*
			item.Last_modified = i.PubDate
			if item.Last_modified.IsZero() {
				item.Last_modified = i.Updated
			}
			h := md5.New()
			fmt.Fprint(h, item.Content)
			//item.Hash = fmt.Sprintf("%x", h.Sum(nil))

		*/
		items = append(items, item)
	}

	return
}

func SaveArticles(items []*ArticleEntity, origin string) (succNum int) {
	var err error
	succNum = 0

	OrmDB = "gofeed"
	selectedEngine := "mysql"
	if selectedEngine == "mysql" {
		Orm, err = xorm.NewEngine("mysql", "www:123x456@tcp(127.0.0.1:3306)/xahoo?charset=utf8")
		//} else if selectedEngine == "sqlite3" {
		//	Orm, err = xorm.NewEngine("sqlite3", OrmDB)
	}
	if err != nil {
		fmt.Println("orm init error:", err)
		return
	}
	Orm.SetMapper(core.SameMapper{})

	//session := Orm.NewSession()
	for _, item := range items {

		item.Origin = origin

        var exist bool

        if len(item.Outer_url) > 1 {
            var queryArticle = ArticleEntity{Outer_url: item.Outer_url}
            //Orm.QueryRow("select * from fh_article where ").Scan(&existArticle)
            rows, err := Orm.Rows(&queryArticle)
            if err != nil {
                fmt.Printf("could not query by outer_url, err:%v\n", err)
            } else {
                defer rows.Close()
                for rows.Next() {
                    err = rows.Scan(&queryArticle)
                    if err != nil {
                        fmt.Printf("could not scan, err:%v\n", err)
                    } else {
                        exist = true
                        break
                    }
                }
            }

            if exist {
                fmt.Printf("outer_url already exist in db:%v\n", item.Outer_url)
                continue
            }
        }



        if item.Visit_url == "" {
            item.Visit_url = MakeArticleUrl(item)
        }

		_, e := Orm.Insert(item)
		if e != nil {
			fmt.Println("insert Article error:", e)
			continue
		}
		//fmt.Println("insert success: num=", num, "all=", succNum, "id=", item.Id)

		// save as hot article, so show

		succNum++
	}

    fmt.Println("all", succNum, "saved")
	return
}

func MakeArticleUrl(a *ArticleEntity) string {
	//strings.a.Id
	sign := "ignorethisstrings"
	str := "http://xahoo.xenith.top/index.php?r=article/show&id=" + fmt.Sprintf("%d", a.Id) + "&sign=" + sign
	return str
}
