package main

import (
	"flag"
	"fmt"
	"regexp"
	"strings"
	//"os"

	//feedreader "./feedreader"
	model "./model"
)

func main() {
	/*
		example url:
		http://news.qq.com/newsgj/rss_newswj.xml			// 腾讯国际
		http://news.qq.com/photon/rss_photo.xml 			// 腾讯图片
		http://n.rss.qq.com/rss/tech_rss.php				// 腾讯科技 // 有图片
		http://tech.qq.com/web/webnews/rss_11.xml			// 腾讯互联网
		http://tech.163.com/special/000944OI/headlines.xml  // 网易科技 // 垃圾广告多
		http://www.ftchinese.com/rss/feed
		http://www.scipark.net/feed/                        // 已过期
		http://feed.williamlong.info/                       // 月光博客
		https://www.zhihu.com/rss                           // 知乎每日精选
		http://www.read.org.cn/feed                         // 效率生活
		http://36kr.com/feed                                // 36kr
		http://dbanotes.net/feed                            // 小道消息
		http://www.ruanyifeng.com/blog/atom.xml             // 阮一峰
		http://www.juzimi.com/feed                          // 鸡汤
	*/
	var url *string = flag.String("url", "", "feed url")
	var doSave *bool = flag.Bool("dosave", true, "do save or debug")
	var originMark *string = flag.String("origin", "", "origin")
	flag.Parse()
	if url == nil || len(*url) == 0 {
		fmt.Println("url cannot be null")
		return
	}

	mark := *originMark
	if len(*originMark) == 0 {
		mark = FindMark(*url)
	}

	//return
	//testReg()

	// after this, its test model
	feed, items, e := model.FetchUrl(*url)
	succNum := 0 //len(items) //
	if *doSave {
		succNum = model.SaveArticles(items, mark)
	}
	fmt.Println("feed len(items)=", len(items), "save success:", succNum, "lines", "feed=", feed, "e=", e)
	/*
		// after this, its test feedreader.Fetch
		feed, err := feedreader.Fetch(*url)
		if err != nil {
			fmt.Fprintln(os.Stderr, err)
		} else {
			fmt.Println("feed title: ", feed.Title)

			fmt.Printf("There are %d item(s) in the feed\n", len(feed.Items))
			for _, i := range feed.Items {
				fmt.Println(i)
			}
		}
	*/
}

func testReg() {
	content := ` <p>this is in a test content <Img 	height="100px" src ="http://testdomain.com/testname.png?tesl=fs%3F#ss"  alt=title_desc> end content <p>this is in a test content <img 	 src ='http://testdomain.com/testname2.png?tesl=fs%3F#ss2' height="200px"  alt=title_desc> end content`
	//content := `<p>this is in a test content <img height="100px" src="http://testdomain.com/testname.png?tesl=fs%3F#ss"  alt=title_desc> image desc </p> content end`
	//regStr := `<img\s*src\s*=\s*['\"]([^'\"]+)['\"][^>]*>`
	imgRegStr := `(?i)<img\b[^<>]*?\bsrc\s*=\s*['\"]([^'\"]+)['\"][^>]*>` //ok
	//regStr := `<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?height\s*=\s*(\'|\")(.*?)\\1[^>]*?width\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>` // failed
	//regStr := `(?i)<\s*img\s+[^>]*?src\s*=\s*['\"]([^'\"].*?)['\"][^>]*?(height|width)\s*=\s*['\"][^'\"].*?['\"][^>])?(width\s*=\s*['\"][^'\"].*?['\"][^>])?\s*>` // ok,failed,failed
	imgRegObj := regexp.MustCompile(imgRegStr)
	imgLinks := imgRegObj.FindAllStringSubmatch(content, -1)
	fmt.Println("content:", content, "MATCHED:", len(imgLinks))
	attrRegStr := `(?i)(height|width)\s*=\s*['\"]([^'\"]+)['\"][^>]*`
	for _, imgLink := range imgLinks {
		fmt.Println("matched images:", imgLink, "len=", len(imgLink), "src=", imgLink[1])
		for _, regElem := range imgLink {
			fmt.Println("	the matched elem:", regElem)
		}
		// 在每一个标签中找height|width,
		attrRegObj := regexp.MustCompile(attrRegStr)
		attrRets := attrRegObj.FindAllStringSubmatch(imgLink[0], -1)
		for _, attrElem := range attrRets {
			fmt.Println("		the attr:", attrElem)
			for _, attrElemSub := range attrElem {
				fmt.Println("			the subelem:", attrElemSub)
			}
		}
	}
}

func FindMark(urlStr string) (mark string) {
	urlElemStr := strings.Split(urlStr, "/")
	if len(urlElemStr) >= 3 {
		domainPart := urlElemStr[2]
		domainPartArr := strings.Split(domainPart, ".")

		ignoreTags := []string{"com", "net", "gov", "org", "info", "edu", "top", "biz", "xyz", "pro", "name", "wang", "tech", "ltd", "club", "vip"}

		if len(domainPartArr[len(domainPartArr)-1]) == 2 {
			domainPartArr = domainPartArr[:len(domainPartArr)-2]
			//fmt.Printf("domain part arr =%v\n", domainPartArr)
		}

		for i := len(domainPartArr) - 1; i >= 0; i-- {
			isIgnoreTags := false
			for _, it := range ignoreTags {
				if it == strings.ToLower(domainPartArr[i]) {
					isIgnoreTags = true
					break
				}
			}

			if isIgnoreTags {
				//fmt.Printf("kick a tag:%v i=%v TAGS=%v\n", domainPartArr[i], i, domainPartArr)
				domainPartArr = domainPartArr[:i]
				//fmt.Printf("after kick TAGS=%v\n", domainPartArr)
			}
		}

		if len(domainPartArr) > 0 {
			mark = domainPartArr[len(domainPartArr)-1]
		} else {
			mark = domainPart
		}

		fmt.Printf("find mark for origin=%v\n", mark)
	}

	mark = strings.ToLower(mark)

	return mark
}
