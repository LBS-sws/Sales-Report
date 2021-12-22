/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : service

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2021-09-24 10:17:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `enums`
-- ----------------------------
DROP TABLE IF EXISTS `enums`;
CREATE TABLE `enums` (
  `EnumType` int(11) NOT NULL,
  `EnumID` int(11) NOT NULL,
  `Text` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `idx` (`EnumType`,`EnumID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of enums
-- ----------------------------
INSERT INTO `enums` VALUES ('1', '0', '');
INSERT INTO `enums` VALUES ('1', '100', '北京市');
INSERT INTO `enums` VALUES ('1', '102', '朝阳区');
INSERT INTO `enums` VALUES ('1', '103', '海淀区');
INSERT INTO `enums` VALUES ('1', '104', '西城区');
INSERT INTO `enums` VALUES ('1', '105', '东城区');
INSERT INTO `enums` VALUES ('1', '106', '石景山区');
INSERT INTO `enums` VALUES ('1', '107', '丰台区');
INSERT INTO `enums` VALUES ('1', '108', '大兴区');
INSERT INTO `enums` VALUES ('1', '109', '昌平区');
INSERT INTO `enums` VALUES ('1', '110', '顺义区');
INSERT INTO `enums` VALUES ('1', '111', '房山区');
INSERT INTO `enums` VALUES ('1', '112', '通州区');
INSERT INTO `enums` VALUES ('1', '113', '');
INSERT INTO `enums` VALUES ('1', '114', '宣武区');
INSERT INTO `enums` VALUES ('1', '115', '门头沟区');
INSERT INTO `enums` VALUES ('1', '200', '天津市');
INSERT INTO `enums` VALUES ('1', '202', '和平区');
INSERT INTO `enums` VALUES ('1', '203', '南开区');
INSERT INTO `enums` VALUES ('1', '204', '河西区');
INSERT INTO `enums` VALUES ('1', '205', '河东区');
INSERT INTO `enums` VALUES ('1', '206', '西青区');
INSERT INTO `enums` VALUES ('1', '207', '东丽区');
INSERT INTO `enums` VALUES ('1', '208', '红桥区');
INSERT INTO `enums` VALUES ('1', '209', '河北区');
INSERT INTO `enums` VALUES ('1', '210', '津南区');
INSERT INTO `enums` VALUES ('1', '211', '北辰区');
INSERT INTO `enums` VALUES ('1', '212', '武清区');
INSERT INTO `enums` VALUES ('1', '213', '空港区');
INSERT INTO `enums` VALUES ('1', '214', '滨海新区');
INSERT INTO `enums` VALUES ('1', '300', '上海市');
INSERT INTO `enums` VALUES ('1', '302', '徐汇区');
INSERT INTO `enums` VALUES ('1', '303', '闵行区');
INSERT INTO `enums` VALUES ('1', '304', '宝山区');
INSERT INTO `enums` VALUES ('1', '305', '成都');
INSERT INTO `enums` VALUES ('1', '306', '长宁区');
INSERT INTO `enums` VALUES ('1', '307', '奉贤区');
INSERT INTO `enums` VALUES ('1', '308', '虹口区');
INSERT INTO `enums` VALUES ('1', '309', '黄埔区');
INSERT INTO `enums` VALUES ('1', '310', '静安区');
INSERT INTO `enums` VALUES ('1', '311', '嘉定区');
INSERT INTO `enums` VALUES ('1', '312', '金山区');
INSERT INTO `enums` VALUES ('1', '313', '昆山区');
INSERT INTO `enums` VALUES ('1', '314', '卢湾区');
INSERT INTO `enums` VALUES ('1', '315', '浦东区');
INSERT INTO `enums` VALUES ('1', '316', '普陀区');
INSERT INTO `enums` VALUES ('1', '317', '青岛');
INSERT INTO `enums` VALUES ('1', '318', '青浦区');
INSERT INTO `enums` VALUES ('1', '319', '松江区');
INSERT INTO `enums` VALUES ('1', '320', '苏州区');
INSERT INTO `enums` VALUES ('1', '321', '杨浦区');
INSERT INTO `enums` VALUES ('1', '322', '闸北区');
INSERT INTO `enums` VALUES ('1', '323', '汇总');
INSERT INTO `enums` VALUES ('1', '400', '重庆市');
INSERT INTO `enums` VALUES ('1', '402', '沙坪坝区');
INSERT INTO `enums` VALUES ('1', '403', '大渡口区');
INSERT INTO `enums` VALUES ('1', '404', '渝中区');
INSERT INTO `enums` VALUES ('1', '405', '渝北区');
INSERT INTO `enums` VALUES ('1', '406', '九龙坡区');
INSERT INTO `enums` VALUES ('1', '407', '巴南区');
INSERT INTO `enums` VALUES ('1', '408', '江北区');
INSERT INTO `enums` VALUES ('1', '409', '北碚区');
INSERT INTO `enums` VALUES ('1', '410', '南岸区');
INSERT INTO `enums` VALUES ('1', '411', '璧山区');
INSERT INTO `enums` VALUES ('1', '412', '重庆市以外地区');
INSERT INTO `enums` VALUES ('1', '413', '万州区');
INSERT INTO `enums` VALUES ('1', '500', '石家庄市');
INSERT INTO `enums` VALUES ('1', '502', '长安区');
INSERT INTO `enums` VALUES ('1', '600', '唐山市');
INSERT INTO `enums` VALUES ('1', '602', '乐亭县海港经济开发区');
INSERT INTO `enums` VALUES ('1', '700', '秦皇岛市');
INSERT INTO `enums` VALUES ('1', '800', '邯郸市');
INSERT INTO `enums` VALUES ('1', '900', '邢台市');
INSERT INTO `enums` VALUES ('1', '1000', '保定市');
INSERT INTO `enums` VALUES ('1', '1100', '张家口市');
INSERT INTO `enums` VALUES ('1', '1200', '承德市');
INSERT INTO `enums` VALUES ('1', '1300', '沧州市');
INSERT INTO `enums` VALUES ('1', '1400', '廊坊市');
INSERT INTO `enums` VALUES ('1', '1402', '广阳区');
INSERT INTO `enums` VALUES ('1', '1403', '安次区');
INSERT INTO `enums` VALUES ('1', '1500', '衡水市');
INSERT INTO `enums` VALUES ('1', '1600', '太原市');
INSERT INTO `enums` VALUES ('1', '1602', '小店区');
INSERT INTO `enums` VALUES ('1', '1700', '大同市');
INSERT INTO `enums` VALUES ('1', '1800', '阳泉市');
INSERT INTO `enums` VALUES ('1', '1900', '长治市');
INSERT INTO `enums` VALUES ('1', '2000', '晋城市');
INSERT INTO `enums` VALUES ('1', '2100', '朔州市');
INSERT INTO `enums` VALUES ('1', '2200', '晋中市');
INSERT INTO `enums` VALUES ('1', '2300', '运城市');
INSERT INTO `enums` VALUES ('1', '2400', '忻州市');
INSERT INTO `enums` VALUES ('1', '2500', '临汾市');
INSERT INTO `enums` VALUES ('1', '2600', '吕梁市');
INSERT INTO `enums` VALUES ('1', '2700', '呼和浩特市');
INSERT INTO `enums` VALUES ('1', '2702', '新城区');
INSERT INTO `enums` VALUES ('1', '2800', '包头市');
INSERT INTO `enums` VALUES ('1', '2900', '乌海市');
INSERT INTO `enums` VALUES ('1', '3000', '赤峰市');
INSERT INTO `enums` VALUES ('1', '3100', '通辽市');
INSERT INTO `enums` VALUES ('1', '3200', '鄂尔多斯市');
INSERT INTO `enums` VALUES ('1', '3300', '呼伦贝尔市');
INSERT INTO `enums` VALUES ('1', '3400', '巴彦淖尔市');
INSERT INTO `enums` VALUES ('1', '3402', '临河区');
INSERT INTO `enums` VALUES ('1', '3500', '乌兰察布市');
INSERT INTO `enums` VALUES ('1', '3600', '兴安盟');
INSERT INTO `enums` VALUES ('1', '3700', '锡林郭勒盟');
INSERT INTO `enums` VALUES ('1', '3800', '阿拉善盟');
INSERT INTO `enums` VALUES ('1', '3900', '沈阳市');
INSERT INTO `enums` VALUES ('1', '3902', '浑南新区');
INSERT INTO `enums` VALUES ('1', '4000', '大连市');
INSERT INTO `enums` VALUES ('1', '4100', '鞍山市');
INSERT INTO `enums` VALUES ('1', '4200', '抚顺市');
INSERT INTO `enums` VALUES ('1', '4300', '本溪市');
INSERT INTO `enums` VALUES ('1', '4400', '丹东市');
INSERT INTO `enums` VALUES ('1', '4500', '锦州市');
INSERT INTO `enums` VALUES ('1', '4600', '营口市');
INSERT INTO `enums` VALUES ('1', '4700', '阜新市');
INSERT INTO `enums` VALUES ('1', '4800', '辽阳市');
INSERT INTO `enums` VALUES ('1', '4900', '盘锦市');
INSERT INTO `enums` VALUES ('1', '5000', '铁岭市');
INSERT INTO `enums` VALUES ('1', '5100', '朝阳市');
INSERT INTO `enums` VALUES ('1', '5200', '葫芦岛市');
INSERT INTO `enums` VALUES ('1', '5300', '长春市');
INSERT INTO `enums` VALUES ('1', '5400', '吉林市');
INSERT INTO `enums` VALUES ('1', '5500', '四平市');
INSERT INTO `enums` VALUES ('1', '5600', '辽源市');
INSERT INTO `enums` VALUES ('1', '5700', '通化市');
INSERT INTO `enums` VALUES ('1', '5800', '白山市');
INSERT INTO `enums` VALUES ('1', '5900', '松原市');
INSERT INTO `enums` VALUES ('1', '6000', '白城市');
INSERT INTO `enums` VALUES ('1', '6100', '延边朝鲜族自治州');
INSERT INTO `enums` VALUES ('1', '6200', '哈尔滨市');
INSERT INTO `enums` VALUES ('1', '6300', '齐齐哈尔市');
INSERT INTO `enums` VALUES ('1', '6400', '鸡西市');
INSERT INTO `enums` VALUES ('1', '6500', '鹤岗市');
INSERT INTO `enums` VALUES ('1', '6600', '双鸭山市');
INSERT INTO `enums` VALUES ('1', '6700', '大庆市');
INSERT INTO `enums` VALUES ('1', '6800', '伊春市');
INSERT INTO `enums` VALUES ('1', '6900', '佳木斯市');
INSERT INTO `enums` VALUES ('1', '7000', '七台河市');
INSERT INTO `enums` VALUES ('1', '7100', '牡丹江市');
INSERT INTO `enums` VALUES ('1', '7200', '黑河市');
INSERT INTO `enums` VALUES ('1', '7300', '绥化市');
INSERT INTO `enums` VALUES ('1', '7400', '大兴安岭地区');
INSERT INTO `enums` VALUES ('1', '7500', '南京市');
INSERT INTO `enums` VALUES ('1', '7502', '鼓楼区');
INSERT INTO `enums` VALUES ('1', '7503', '秦淮区');
INSERT INTO `enums` VALUES ('1', '7504', '玄武区');
INSERT INTO `enums` VALUES ('1', '7505', '建邺区');
INSERT INTO `enums` VALUES ('1', '7506', '栖霞区');
INSERT INTO `enums` VALUES ('1', '7507', '江宁区');
INSERT INTO `enums` VALUES ('1', '7508', '六合区');
INSERT INTO `enums` VALUES ('1', '7509', '雨花区');
INSERT INTO `enums` VALUES ('1', '7510', '浦口区');
INSERT INTO `enums` VALUES ('1', '7511', '白下区');
INSERT INTO `enums` VALUES ('1', '7512', '下关区');
INSERT INTO `enums` VALUES ('1', '7513', '溧水区');
INSERT INTO `enums` VALUES ('1', '7514', '高淳区');
INSERT INTO `enums` VALUES ('1', '7515', '大厂区');
INSERT INTO `enums` VALUES ('1', '7600', '无锡市');
INSERT INTO `enums` VALUES ('1', '7602', '梁溪区');
INSERT INTO `enums` VALUES ('1', '7603', '滨湖区');
INSERT INTO `enums` VALUES ('1', '7604', '新吴区');
INSERT INTO `enums` VALUES ('1', '7605', '锡山区');
INSERT INTO `enums` VALUES ('1', '7606', '惠山区');
INSERT INTO `enums` VALUES ('1', '7607', '江阴市');
INSERT INTO `enums` VALUES ('1', '7608', '宜兴市');
INSERT INTO `enums` VALUES ('1', '7700', '徐州市');
INSERT INTO `enums` VALUES ('1', '7702', '泉山区');
INSERT INTO `enums` VALUES ('1', '7800', '常州市');
INSERT INTO `enums` VALUES ('1', '7802', '武进区');
INSERT INTO `enums` VALUES ('1', '7803', '新北区');
INSERT INTO `enums` VALUES ('1', '7804', '天宁区');
INSERT INTO `enums` VALUES ('1', '7805', '钟楼区');
INSERT INTO `enums` VALUES ('1', '7806', '金坛县');
INSERT INTO `enums` VALUES ('1', '7807', '溧阳市');
INSERT INTO `enums` VALUES ('1', '7900', '苏州市');
INSERT INTO `enums` VALUES ('1', '7902', '姑苏区');
INSERT INTO `enums` VALUES ('1', '7903', '虎丘区');
INSERT INTO `enums` VALUES ('1', '7904', '吴中区');
INSERT INTO `enums` VALUES ('1', '7905', '相城区');
INSERT INTO `enums` VALUES ('1', '7906', '吴江区');
INSERT INTO `enums` VALUES ('1', '7907', '常熟市');
INSERT INTO `enums` VALUES ('1', '7908', '张家港市');
INSERT INTO `enums` VALUES ('1', '7909', '昆山市');
INSERT INTO `enums` VALUES ('1', '7910', '太仓市');
INSERT INTO `enums` VALUES ('1', '8000', '南通市');
INSERT INTO `enums` VALUES ('1', '8002', '崇川区');
INSERT INTO `enums` VALUES ('1', '8003', '港闸区');
INSERT INTO `enums` VALUES ('1', '8004', '通州区');
INSERT INTO `enums` VALUES ('1', '8100', '连云港市');
INSERT INTO `enums` VALUES ('1', '8200', '淮安市');
INSERT INTO `enums` VALUES ('1', '8300', '盐城市');
INSERT INTO `enums` VALUES ('1', '8400', '扬州市');
INSERT INTO `enums` VALUES ('1', '8402', '仪征市');
INSERT INTO `enums` VALUES ('1', '8500', '镇江市');
INSERT INTO `enums` VALUES ('1', '8502', '京口区');
INSERT INTO `enums` VALUES ('1', '8600', '泰州市');
INSERT INTO `enums` VALUES ('1', '8700', '宿迁市');
INSERT INTO `enums` VALUES ('1', '8800', '杭州市');
INSERT INTO `enums` VALUES ('1', '8802', '滨江区');
INSERT INTO `enums` VALUES ('1', '8803', '江干区');
INSERT INTO `enums` VALUES ('1', '8804', '拱墅区');
INSERT INTO `enums` VALUES ('1', '8805', '上城区');
INSERT INTO `enums` VALUES ('1', '8806', '下城区');
INSERT INTO `enums` VALUES ('1', '8807', '西湖区');
INSERT INTO `enums` VALUES ('1', '8808', '萧山区');
INSERT INTO `enums` VALUES ('1', '8809', '余杭区');
INSERT INTO `enums` VALUES ('1', '8810', '其他');
INSERT INTO `enums` VALUES ('1', '8900', '宁波市');
INSERT INTO `enums` VALUES ('1', '8902', '江北区');
INSERT INTO `enums` VALUES ('1', '8903', '鄞州区');
INSERT INTO `enums` VALUES ('1', '8904', '北仑区');
INSERT INTO `enums` VALUES ('1', '8905', '海曙区');
INSERT INTO `enums` VALUES ('1', '8906', '镇海区');
INSERT INTO `enums` VALUES ('1', '8907', '奉化区');
INSERT INTO `enums` VALUES ('1', '8908', '余姚');
INSERT INTO `enums` VALUES ('1', '9000', '温州市');
INSERT INTO `enums` VALUES ('1', '9100', '嘉兴市');
INSERT INTO `enums` VALUES ('1', '9102', '海盐县');
INSERT INTO `enums` VALUES ('1', '9200', '湖州市');
INSERT INTO `enums` VALUES ('1', '9300', '绍兴市');
INSERT INTO `enums` VALUES ('1', '9400', '金华市');
INSERT INTO `enums` VALUES ('1', '9402', '婺城区');
INSERT INTO `enums` VALUES ('1', '9500', '衢州市');
INSERT INTO `enums` VALUES ('1', '9600', '舟山市');
INSERT INTO `enums` VALUES ('1', '9700', '台州市');
INSERT INTO `enums` VALUES ('1', '9800', '丽水市');
INSERT INTO `enums` VALUES ('1', '9900', '合肥市');
INSERT INTO `enums` VALUES ('1', '9902', '庐阳区');
INSERT INTO `enums` VALUES ('1', '9903', '瑶海区');
INSERT INTO `enums` VALUES ('1', '9904', '包河区');
INSERT INTO `enums` VALUES ('1', '9905', '蜀山区');
INSERT INTO `enums` VALUES ('1', '9906', '政务区');
INSERT INTO `enums` VALUES ('1', '9907', '经济开发技术区');
INSERT INTO `enums` VALUES ('1', '9908', '高新区');
INSERT INTO `enums` VALUES ('1', '10000', '芜湖市');
INSERT INTO `enums` VALUES ('1', '10100', '蚌埠市');
INSERT INTO `enums` VALUES ('1', '10200', '淮南市');
INSERT INTO `enums` VALUES ('1', '10300', '马鞍山市');
INSERT INTO `enums` VALUES ('1', '10400', '淮北市');
INSERT INTO `enums` VALUES ('1', '10500', '铜陵市');
INSERT INTO `enums` VALUES ('1', '10600', '安庆市');
INSERT INTO `enums` VALUES ('1', '10700', '黄山市');
INSERT INTO `enums` VALUES ('1', '10800', '滁州市');
INSERT INTO `enums` VALUES ('1', '10900', '阜阳市');
INSERT INTO `enums` VALUES ('1', '11000', '宿州市');
INSERT INTO `enums` VALUES ('1', '11100', '六安市');
INSERT INTO `enums` VALUES ('1', '11200', '亳州市');
INSERT INTO `enums` VALUES ('1', '11300', '池州市');
INSERT INTO `enums` VALUES ('1', '11400', '宣城市');
INSERT INTO `enums` VALUES ('1', '11500', '福州市');
INSERT INTO `enums` VALUES ('1', '11502', '01鼓楼区');
INSERT INTO `enums` VALUES ('1', '11503', '02台江区');
INSERT INTO `enums` VALUES ('1', '11504', '03仓山区');
INSERT INTO `enums` VALUES ('1', '11505', '04晋安区');
INSERT INTO `enums` VALUES ('1', '11506', '05马尾区');
INSERT INTO `enums` VALUES ('1', '11507', '06福清');
INSERT INTO `enums` VALUES ('1', '11508', '07长乐');
INSERT INTO `enums` VALUES ('1', '11509', '08闽侯');
INSERT INTO `enums` VALUES ('1', '11510', '09连江');
INSERT INTO `enums` VALUES ('1', '11511', '10罗源');
INSERT INTO `enums` VALUES ('1', '11512', '11闽清');
INSERT INTO `enums` VALUES ('1', '11513', '12永泰');
INSERT INTO `enums` VALUES ('1', '11600', '厦门市');
INSERT INTO `enums` VALUES ('1', '11700', '莆田市');
INSERT INTO `enums` VALUES ('1', '11702', '城厢区');
INSERT INTO `enums` VALUES ('1', '11800', '三明市');
INSERT INTO `enums` VALUES ('1', '11900', '泉州市');
INSERT INTO `enums` VALUES ('1', '12000', '漳州市');
INSERT INTO `enums` VALUES ('1', '12100', '南平市');
INSERT INTO `enums` VALUES ('1', '12200', '龙岩市');
INSERT INTO `enums` VALUES ('1', '12300', '宁德市');
INSERT INTO `enums` VALUES ('1', '12400', '南昌市');
INSERT INTO `enums` VALUES ('1', '12402', '红谷滩新区');
INSERT INTO `enums` VALUES ('1', '12500', '景德镇市');
INSERT INTO `enums` VALUES ('1', '12600', '萍乡市');
INSERT INTO `enums` VALUES ('1', '12700', '九江市');
INSERT INTO `enums` VALUES ('1', '12702', '经济开发区');
INSERT INTO `enums` VALUES ('1', '12800', '新余市');
INSERT INTO `enums` VALUES ('1', '12900', '鹰潭市');
INSERT INTO `enums` VALUES ('1', '13000', '赣州市');
INSERT INTO `enums` VALUES ('1', '13100', '吉安市');
INSERT INTO `enums` VALUES ('1', '13200', '宜春市');
INSERT INTO `enums` VALUES ('1', '13300', '抚州市');
INSERT INTO `enums` VALUES ('1', '13400', '上饶市');
INSERT INTO `enums` VALUES ('1', '13500', '济南市');
INSERT INTO `enums` VALUES ('1', '13600', '青岛市');
INSERT INTO `enums` VALUES ('1', '13700', '淄博市');
INSERT INTO `enums` VALUES ('1', '13800', '枣庄市');
INSERT INTO `enums` VALUES ('1', '13900', '东营市');
INSERT INTO `enums` VALUES ('1', '14000', '烟台市');
INSERT INTO `enums` VALUES ('1', '14100', '潍坊市');
INSERT INTO `enums` VALUES ('1', '14200', '济宁市');
INSERT INTO `enums` VALUES ('1', '14300', '泰安市');
INSERT INTO `enums` VALUES ('1', '14400', '威海市');
INSERT INTO `enums` VALUES ('1', '14500', '日照市');
INSERT INTO `enums` VALUES ('1', '14600', '莱芜市');
INSERT INTO `enums` VALUES ('1', '14700', '临沂市');
INSERT INTO `enums` VALUES ('1', '14800', '德州市');
INSERT INTO `enums` VALUES ('1', '14900', '聊城市');
INSERT INTO `enums` VALUES ('1', '15000', '滨州市');
INSERT INTO `enums` VALUES ('1', '15100', '菏泽市');
INSERT INTO `enums` VALUES ('1', '15200', '郑州市');
INSERT INTO `enums` VALUES ('1', '15202', '中原区');
INSERT INTO `enums` VALUES ('1', '15300', '开封市');
INSERT INTO `enums` VALUES ('1', '15400', '洛阳市');
INSERT INTO `enums` VALUES ('1', '15500', '平顶山市');
INSERT INTO `enums` VALUES ('1', '15600', '安阳市');
INSERT INTO `enums` VALUES ('1', '15700', '鹤壁市');
INSERT INTO `enums` VALUES ('1', '15800', '新乡市');
INSERT INTO `enums` VALUES ('1', '15900', '焦作市');
INSERT INTO `enums` VALUES ('1', '16000', '濮阳市');
INSERT INTO `enums` VALUES ('1', '16100', '许昌市');
INSERT INTO `enums` VALUES ('1', '16200', '漯河市');
INSERT INTO `enums` VALUES ('1', '16300', '三门峡市');
INSERT INTO `enums` VALUES ('1', '16400', '南阳市');
INSERT INTO `enums` VALUES ('1', '16500', '商丘市');
INSERT INTO `enums` VALUES ('1', '16600', '信阳市');
INSERT INTO `enums` VALUES ('1', '16700', '周口市');
INSERT INTO `enums` VALUES ('1', '16800', '驻马店市');
INSERT INTO `enums` VALUES ('1', '16900', '济源市');
INSERT INTO `enums` VALUES ('1', '17000', '武汉市');
INSERT INTO `enums` VALUES ('1', '17002', '江岸区');
INSERT INTO `enums` VALUES ('1', '17003', '江汉区');
INSERT INTO `enums` VALUES ('1', '17004', '硚口区');
INSERT INTO `enums` VALUES ('1', '17005', '汉阳区');
INSERT INTO `enums` VALUES ('1', '17006', '武昌区');
INSERT INTO `enums` VALUES ('1', '17007', '青山区');
INSERT INTO `enums` VALUES ('1', '17008', '洪山区');
INSERT INTO `enums` VALUES ('1', '17009', '东西湖区');
INSERT INTO `enums` VALUES ('1', '17010', '汉南区');
INSERT INTO `enums` VALUES ('1', '17011', '蔡甸区');
INSERT INTO `enums` VALUES ('1', '17012', '江夏区');
INSERT INTO `enums` VALUES ('1', '17013', '黄陂区');
INSERT INTO `enums` VALUES ('1', '17014', '新洲区');
INSERT INTO `enums` VALUES ('1', '17015', '东湖新技术开发区');
INSERT INTO `enums` VALUES ('1', '17100', '黄石市');
INSERT INTO `enums` VALUES ('1', '17200', '十堰市');
INSERT INTO `enums` VALUES ('1', '17300', '宜昌市');
INSERT INTO `enums` VALUES ('1', '17400', '襄阳市');
INSERT INTO `enums` VALUES ('1', '17500', '鄂州市');
INSERT INTO `enums` VALUES ('1', '17600', '荆门市');
INSERT INTO `enums` VALUES ('1', '17700', '孝感市');
INSERT INTO `enums` VALUES ('1', '17800', '荆州市');
INSERT INTO `enums` VALUES ('1', '17900', '黄冈市');
INSERT INTO `enums` VALUES ('1', '17902', '黄州区');
INSERT INTO `enums` VALUES ('1', '18000', '咸宁市');
INSERT INTO `enums` VALUES ('1', '18100', '随州市');
INSERT INTO `enums` VALUES ('1', '18200', '恩施土家族苗族自治州');
INSERT INTO `enums` VALUES ('1', '18300', '长沙市');
INSERT INTO `enums` VALUES ('1', '18302', '岳麓区');
INSERT INTO `enums` VALUES ('1', '18400', '株洲市');
INSERT INTO `enums` VALUES ('1', '18500', '湘潭市');
INSERT INTO `enums` VALUES ('1', '18600', '衡阳市');
INSERT INTO `enums` VALUES ('1', '18700', '邵阳市');
INSERT INTO `enums` VALUES ('1', '18800', '岳阳市');
INSERT INTO `enums` VALUES ('1', '18900', '常德市');
INSERT INTO `enums` VALUES ('1', '19000', '张家界市');
INSERT INTO `enums` VALUES ('1', '19100', '益阳市');
INSERT INTO `enums` VALUES ('1', '19200', '郴州市');
INSERT INTO `enums` VALUES ('1', '19300', '永州市');
INSERT INTO `enums` VALUES ('1', '19400', '怀化市');
INSERT INTO `enums` VALUES ('1', '19500', '娄底市');
INSERT INTO `enums` VALUES ('1', '19600', '湘西土家族苗族自治州');
INSERT INTO `enums` VALUES ('1', '19700', '广州市');
INSERT INTO `enums` VALUES ('1', '19702', '天河區');
INSERT INTO `enums` VALUES ('1', '19703', '海珠區');
INSERT INTO `enums` VALUES ('1', '19704', '越秀區');
INSERT INTO `enums` VALUES ('1', '19705', '荔灣區');
INSERT INTO `enums` VALUES ('1', '19706', '白雲區');
INSERT INTO `enums` VALUES ('1', '19707', '番禺區');
INSERT INTO `enums` VALUES ('1', '19708', '黃埔區');
INSERT INTO `enums` VALUES ('1', '19709', '花都區');
INSERT INTO `enums` VALUES ('1', '19710', '增城區');
INSERT INTO `enums` VALUES ('1', '19711', '蘿崗區');
INSERT INTO `enums` VALUES ('1', '19712', '清遠市');
INSERT INTO `enums` VALUES ('1', '19713', '從化區');
INSERT INTO `enums` VALUES ('1', '19800', '韶关市');
INSERT INTO `enums` VALUES ('1', '19900', '深圳市');
INSERT INTO `enums` VALUES ('1', '19902', '福田区');
INSERT INTO `enums` VALUES ('1', '19903', '南山区');
INSERT INTO `enums` VALUES ('1', '19904', '罗湖区');
INSERT INTO `enums` VALUES ('1', '19905', '宝安区');
INSERT INTO `enums` VALUES ('1', '19906', '龙岗区');
INSERT INTO `enums` VALUES ('1', '19907', '盐田区');
INSERT INTO `enums` VALUES ('1', '19908', '龙华新区');
INSERT INTO `enums` VALUES ('1', '19909', '');
INSERT INTO `enums` VALUES ('1', '20000', '珠海市');
INSERT INTO `enums` VALUES ('1', '20002', '拱北区11');
INSERT INTO `enums` VALUES ('1', '20003', '横琴区12');
INSERT INTO `enums` VALUES ('1', '20004', '吉大区13');
INSERT INTO `enums` VALUES ('1', '20005', '南屏区15');
INSERT INTO `enums` VALUES ('1', '20006', '香洲区17');
INSERT INTO `enums` VALUES ('1', '20007', '唐家区20');
INSERT INTO `enums` VALUES ('1', '20008', '斗门区25');
INSERT INTO `enums` VALUES ('1', '20009', '夏湾区22');
INSERT INTO `enums` VALUES ('1', '20010', '');
INSERT INTO `enums` VALUES ('1', '20011', '');
INSERT INTO `enums` VALUES ('1', '20012', '');
INSERT INTO `enums` VALUES ('1', '20100', '汕头市');
INSERT INTO `enums` VALUES ('1', '20102', '龙湖区');
INSERT INTO `enums` VALUES ('1', '20200', '佛山市');
INSERT INTO `enums` VALUES ('1', '20202', '南海区');
INSERT INTO `enums` VALUES ('1', '20203', '三水区');
INSERT INTO `enums` VALUES ('1', '20204', '禅城区');
INSERT INTO `enums` VALUES ('1', '20205', '顺德区');
INSERT INTO `enums` VALUES ('1', '20206', '高明区');
INSERT INTO `enums` VALUES ('1', '20300', '江门市');
INSERT INTO `enums` VALUES ('1', '20302', '江门区');
INSERT INTO `enums` VALUES ('1', '20303', '新会区');
INSERT INTO `enums` VALUES ('1', '20304', '台山区');
INSERT INTO `enums` VALUES ('1', '20305', '鹤山区');
INSERT INTO `enums` VALUES ('1', '20306', '开平区');
INSERT INTO `enums` VALUES ('1', '20307', '恩平区');
INSERT INTO `enums` VALUES ('1', '20400', '湛江市');
INSERT INTO `enums` VALUES ('1', '20500', '茂名市');
INSERT INTO `enums` VALUES ('1', '20600', '肇庆市');
INSERT INTO `enums` VALUES ('1', '20602', '怀集');
INSERT INTO `enums` VALUES ('1', '20603', '四会');
INSERT INTO `enums` VALUES ('1', '20604', '端州区');
INSERT INTO `enums` VALUES ('1', '20605', '金利区');
INSERT INTO `enums` VALUES ('1', '20606', '高要区');
INSERT INTO `enums` VALUES ('1', '20607', '鼎湖区');
INSERT INTO `enums` VALUES ('1', '20608', '云浮');
INSERT INTO `enums` VALUES ('1', '20700', '惠州市');
INSERT INTO `enums` VALUES ('1', '20702', '石湾区');
INSERT INTO `enums` VALUES ('1', '20703', '博罗');
INSERT INTO `enums` VALUES ('1', '20704', '惠城区');
INSERT INTO `enums` VALUES ('1', '20705', '仲恺高新区');
INSERT INTO `enums` VALUES ('1', '20800', '梅州市');
INSERT INTO `enums` VALUES ('1', '20900', '汕尾市');
INSERT INTO `enums` VALUES ('1', '21000', '河源市');
INSERT INTO `enums` VALUES ('1', '21100', '阳江市');
INSERT INTO `enums` VALUES ('1', '21200', '清远市');
INSERT INTO `enums` VALUES ('1', '21300', '东莞市');
INSERT INTO `enums` VALUES ('1', '21302', '东城区');
INSERT INTO `enums` VALUES ('1', '21303', '南城区');
INSERT INTO `enums` VALUES ('1', '21304', '莞城区');
INSERT INTO `enums` VALUES ('1', '21305', '万江区');
INSERT INTO `enums` VALUES ('1', '21306', '长安镇');
INSERT INTO `enums` VALUES ('1', '21307', '虎门镇');
INSERT INTO `enums` VALUES ('1', '21308', '厚街镇');
INSERT INTO `enums` VALUES ('1', '21309', '沙田镇');
INSERT INTO `enums` VALUES ('1', '21310', '大朗镇');
INSERT INTO `enums` VALUES ('1', '21311', '横沥镇');
INSERT INTO `enums` VALUES ('1', '21312', '东坑镇');
INSERT INTO `enums` VALUES ('1', '21313', '企石镇');
INSERT INTO `enums` VALUES ('1', '21314', '常平镇');
INSERT INTO `enums` VALUES ('1', '21315', '桥头镇');
INSERT INTO `enums` VALUES ('1', '21316', '黄江镇');
INSERT INTO `enums` VALUES ('1', '21317', '凤岗镇');
INSERT INTO `enums` VALUES ('1', '21318', '石碣镇');
INSERT INTO `enums` VALUES ('1', '21319', '石龙镇');
INSERT INTO `enums` VALUES ('1', '21320', '石排镇');
INSERT INTO `enums` VALUES ('1', '21321', '茶山镇');
INSERT INTO `enums` VALUES ('1', '21322', '松山湖');
INSERT INTO `enums` VALUES ('1', '21323', '寮步镇');
INSERT INTO `enums` VALUES ('1', '21324', '清溪镇');
INSERT INTO `enums` VALUES ('1', '21325', '大岭山');
INSERT INTO `enums` VALUES ('1', '21326', '高埗镇　');
INSERT INTO `enums` VALUES ('1', '21327', '塘厦镇');
INSERT INTO `enums` VALUES ('1', '21328', '麻涌镇　');
INSERT INTO `enums` VALUES ('1', '21329', '望牛墩镇　');
INSERT INTO `enums` VALUES ('1', '21330', '中堂镇');
INSERT INTO `enums` VALUES ('1', '21331', '洪梅镇');
INSERT INTO `enums` VALUES ('1', '21332', '道滘镇');
INSERT INTO `enums` VALUES ('1', '21333', '谢岗镇');
INSERT INTO `enums` VALUES ('1', '21334', '樟木头镇');
INSERT INTO `enums` VALUES ('1', '21400', '中山市');
INSERT INTO `enums` VALUES ('1', '21402', '东区');
INSERT INTO `enums` VALUES ('1', '21403', '小榄镇');
INSERT INTO `enums` VALUES ('1', '21404', '西区');
INSERT INTO `enums` VALUES ('1', '21405', '南区');
INSERT INTO `enums` VALUES ('1', '21406', '石岐区（北区）');
INSERT INTO `enums` VALUES ('1', '21407', '沙溪镇');
INSERT INTO `enums` VALUES ('1', '21408', '东升镇');
INSERT INTO `enums` VALUES ('1', '21409', '东凤镇');
INSERT INTO `enums` VALUES ('1', '21410', '坦洲镇');
INSERT INTO `enums` VALUES ('1', '21411', '三乡镇');
INSERT INTO `enums` VALUES ('1', '21412', '古镇镇');
INSERT INTO `enums` VALUES ('1', '21413', '横栏镇');
INSERT INTO `enums` VALUES ('1', '21414', '黄圃镇');
INSERT INTO `enums` VALUES ('1', '21415', '南头镇');
INSERT INTO `enums` VALUES ('1', '21416', '三角镇');
INSERT INTO `enums` VALUES ('1', '21417', '火炬开发区');
INSERT INTO `enums` VALUES ('1', '21418', '神湾镇');
INSERT INTO `enums` VALUES ('1', '21419', '板芙镇');
INSERT INTO `enums` VALUES ('1', '21420', '大涌镇');
INSERT INTO `enums` VALUES ('1', '21421', '阜沙镇');
INSERT INTO `enums` VALUES ('1', '21422', '南朗镇');
INSERT INTO `enums` VALUES ('1', '21423', '港口镇');
INSERT INTO `enums` VALUES ('1', '21424', '五桂山');
INSERT INTO `enums` VALUES ('1', '21425', '民众镇');
INSERT INTO `enums` VALUES ('1', '21500', '潮州市');
INSERT INTO `enums` VALUES ('1', '21600', '揭阳市');
INSERT INTO `enums` VALUES ('1', '21700', '云浮市');
INSERT INTO `enums` VALUES ('1', '21702', '新兴');
INSERT INTO `enums` VALUES ('1', '21703', '云城区');
INSERT INTO `enums` VALUES ('1', '21704', '罗定');
INSERT INTO `enums` VALUES ('1', '21800', '南宁市');
INSERT INTO `enums` VALUES ('1', '21802', '青秀区');
INSERT INTO `enums` VALUES ('1', '21803', '兴宁区');
INSERT INTO `enums` VALUES ('1', '21804', '西乡塘区');
INSERT INTO `enums` VALUES ('1', '21805', '江南区');
INSERT INTO `enums` VALUES ('1', '21806', '良庆区');
INSERT INTO `enums` VALUES ('1', '21807', '邕宁区');
INSERT INTO `enums` VALUES ('1', '21900', '柳州市');
INSERT INTO `enums` VALUES ('1', '21902', '柳北区');
INSERT INTO `enums` VALUES ('1', '21903', '鱼峰区');
INSERT INTO `enums` VALUES ('1', '22000', '桂林市');
INSERT INTO `enums` VALUES ('1', '22002', '荔浦县');
INSERT INTO `enums` VALUES ('1', '22003', '七星区');
INSERT INTO `enums` VALUES ('1', '22100', '梧州市');
INSERT INTO `enums` VALUES ('1', '22200', '北海市');
INSERT INTO `enums` VALUES ('1', '22202', '海城区');
INSERT INTO `enums` VALUES ('1', '22300', '防城港市');
INSERT INTO `enums` VALUES ('1', '22302', '东兴市');
INSERT INTO `enums` VALUES ('1', '22400', '钦州市');
INSERT INTO `enums` VALUES ('1', '22500', '贵港市');
INSERT INTO `enums` VALUES ('1', '22600', '玉林市');
INSERT INTO `enums` VALUES ('1', '22602', '容县');
INSERT INTO `enums` VALUES ('1', '22700', '百色市');
INSERT INTO `enums` VALUES ('1', '22702', '右江区');
INSERT INTO `enums` VALUES ('1', '22800', '贺州市');
INSERT INTO `enums` VALUES ('1', '22900', '河池市');
INSERT INTO `enums` VALUES ('1', '22902', '容县');
INSERT INTO `enums` VALUES ('1', '23000', '来宾市');
INSERT INTO `enums` VALUES ('1', '23100', '崇左市');
INSERT INTO `enums` VALUES ('1', '23200', '海口市');
INSERT INTO `enums` VALUES ('1', '23300', '三亚市');
INSERT INTO `enums` VALUES ('1', '23302', '吉阳区');
INSERT INTO `enums` VALUES ('1', '23400', '三沙市');
INSERT INTO `enums` VALUES ('1', '23500', '儋州市');
INSERT INTO `enums` VALUES ('1', '23600', '成都市');
INSERT INTO `enums` VALUES ('1', '23602', '成华区');
INSERT INTO `enums` VALUES ('1', '23603', '青羊区');
INSERT INTO `enums` VALUES ('1', '23604', '武侯区');
INSERT INTO `enums` VALUES ('1', '23605', '金牛区');
INSERT INTO `enums` VALUES ('1', '23606', '高新区');
INSERT INTO `enums` VALUES ('1', '23607', '锦江区');
INSERT INTO `enums` VALUES ('1', '23608', '龙泉驿区');
INSERT INTO `enums` VALUES ('1', '23609', '双流区');
INSERT INTO `enums` VALUES ('1', '23610', '新都区');
INSERT INTO `enums` VALUES ('1', '23611', '郫都区');
INSERT INTO `enums` VALUES ('1', '23612', '温江区');
INSERT INTO `enums` VALUES ('1', '23613', '天府新区');
INSERT INTO `enums` VALUES ('1', '23614', '新津县');
INSERT INTO `enums` VALUES ('1', '23700', '自贡市');
INSERT INTO `enums` VALUES ('1', '23800', '攀枝花市');
INSERT INTO `enums` VALUES ('1', '23802', '东区');
INSERT INTO `enums` VALUES ('1', '23900', '泸州市');
INSERT INTO `enums` VALUES ('1', '24000', '德阳市');
INSERT INTO `enums` VALUES ('1', '24100', '绵阳市');
INSERT INTO `enums` VALUES ('1', '24200', '广元市');
INSERT INTO `enums` VALUES ('1', '24300', '遂宁市');
INSERT INTO `enums` VALUES ('1', '24302', '蓬溪县');
INSERT INTO `enums` VALUES ('1', '24400', '内江市');
INSERT INTO `enums` VALUES ('1', '24500', '乐山市');
INSERT INTO `enums` VALUES ('1', '24600', '南充市');
INSERT INTO `enums` VALUES ('1', '24602', '顺庆区');
INSERT INTO `enums` VALUES ('1', '24700', '眉山市');
INSERT INTO `enums` VALUES ('1', '24800', '宜宾市');
INSERT INTO `enums` VALUES ('1', '24900', '广安市');
INSERT INTO `enums` VALUES ('1', '25000', '达州市');
INSERT INTO `enums` VALUES ('1', '25100', '雅安市');
INSERT INTO `enums` VALUES ('1', '25200', '巴中市');
INSERT INTO `enums` VALUES ('1', '25300', '资阳市');
INSERT INTO `enums` VALUES ('1', '25400', '阿坝藏族羌族自治州');
INSERT INTO `enums` VALUES ('1', '25500', '甘孜藏族自治州');
INSERT INTO `enums` VALUES ('1', '25600', '凉山彝族自治州');
INSERT INTO `enums` VALUES ('1', '25700', '贵阳市');
INSERT INTO `enums` VALUES ('1', '25800', '六盘水市');
INSERT INTO `enums` VALUES ('1', '25900', '遵义市');
INSERT INTO `enums` VALUES ('1', '26000', '安顺市');
INSERT INTO `enums` VALUES ('1', '26100', '毕节市');
INSERT INTO `enums` VALUES ('1', '26200', '铜仁市');
INSERT INTO `enums` VALUES ('1', '26300', '黔西南布依族苗族自治州');
INSERT INTO `enums` VALUES ('1', '26400', '黔东南苗族侗族自治州');
INSERT INTO `enums` VALUES ('1', '26500', '黔南布依族苗族自治州');
INSERT INTO `enums` VALUES ('1', '26600', '昆明市');
INSERT INTO `enums` VALUES ('1', '26700', '曲靖市');
INSERT INTO `enums` VALUES ('1', '26800', '玉溪市');
INSERT INTO `enums` VALUES ('1', '26900', '保山市');
INSERT INTO `enums` VALUES ('1', '27000', '昭通市');
INSERT INTO `enums` VALUES ('1', '27100', '丽江市');
INSERT INTO `enums` VALUES ('1', '27200', '普洱市');
INSERT INTO `enums` VALUES ('1', '27300', '临沧市');
INSERT INTO `enums` VALUES ('1', '27400', '楚雄彝族自治州');
INSERT INTO `enums` VALUES ('1', '27500', '红河哈尼族彝族自治州');
INSERT INTO `enums` VALUES ('1', '27600', '文山壮族苗族自治州');
INSERT INTO `enums` VALUES ('1', '27700', '西双版纳傣族自治州');
INSERT INTO `enums` VALUES ('1', '27800', '大理白族自治州');
INSERT INTO `enums` VALUES ('1', '27900', '德宏傣族景颇族自治州');
INSERT INTO `enums` VALUES ('1', '28000', '怒江傈僳族自治州');
INSERT INTO `enums` VALUES ('1', '28100', '迪庆藏族自治州');
INSERT INTO `enums` VALUES ('1', '28200', '拉萨市');
INSERT INTO `enums` VALUES ('1', '28300', '昌都市');
INSERT INTO `enums` VALUES ('1', '28400', '山南市');
INSERT INTO `enums` VALUES ('1', '28500', '日喀则市');
INSERT INTO `enums` VALUES ('1', '28600', '那曲地区');
INSERT INTO `enums` VALUES ('1', '28700', '阿里地区');
INSERT INTO `enums` VALUES ('1', '28800', '林芝市');
INSERT INTO `enums` VALUES ('1', '28900', '西安市');
INSERT INTO `enums` VALUES ('1', '28902', '未央区');
INSERT INTO `enums` VALUES ('1', '28903', '经开区');
INSERT INTO `enums` VALUES ('1', '28904', '莲湖区');
INSERT INTO `enums` VALUES ('1', '28905', '灞桥区');
INSERT INTO `enums` VALUES ('1', '28906', '高新区');
INSERT INTO `enums` VALUES ('1', '28907', '碑林区');
INSERT INTO `enums` VALUES ('1', '28908', '长安区');
INSERT INTO `enums` VALUES ('1', '28909', '临潼区');
INSERT INTO `enums` VALUES ('1', '28910', '临渭区');
INSERT INTO `enums` VALUES ('1', '28911', '曲江新区');
INSERT INTO `enums` VALUES ('1', '28912', '新城区');
INSERT INTO `enums` VALUES ('1', '28913', '西咸新区');
INSERT INTO `enums` VALUES ('1', '28914', '雁塔区');
INSERT INTO `enums` VALUES ('1', '28915', '临潼市');
INSERT INTO `enums` VALUES ('1', '29000', '铜川市');
INSERT INTO `enums` VALUES ('1', '29100', '宝鸡市');
INSERT INTO `enums` VALUES ('1', '29102', '渭经区');
INSERT INTO `enums` VALUES ('1', '29200', '咸阳市');
INSERT INTO `enums` VALUES ('1', '29202', '渭城区');
INSERT INTO `enums` VALUES ('1', '29203', '秦都区');
INSERT INTO `enums` VALUES ('1', '29204', '杨凌区');
INSERT INTO `enums` VALUES ('1', '29300', '渭南市');
INSERT INTO `enums` VALUES ('1', '29400', '延安市');
INSERT INTO `enums` VALUES ('1', '29500', '汉中市');
INSERT INTO `enums` VALUES ('1', '29502', '汉台区');
INSERT INTO `enums` VALUES ('1', '29600', '榆林市');
INSERT INTO `enums` VALUES ('1', '29700', '安康市');
INSERT INTO `enums` VALUES ('1', '29800', '商洛市');
INSERT INTO `enums` VALUES ('1', '29900', '兰州市');
INSERT INTO `enums` VALUES ('1', '30000', '嘉峪关市');
INSERT INTO `enums` VALUES ('1', '30100', '金昌市');
INSERT INTO `enums` VALUES ('1', '30200', '白银市');
INSERT INTO `enums` VALUES ('1', '30300', '天水市');
INSERT INTO `enums` VALUES ('1', '30400', '武威市');
INSERT INTO `enums` VALUES ('1', '30500', '张掖市');
INSERT INTO `enums` VALUES ('1', '30600', '平凉市');
INSERT INTO `enums` VALUES ('1', '30700', '酒泉市');
INSERT INTO `enums` VALUES ('1', '30800', '庆阳市');
INSERT INTO `enums` VALUES ('1', '30900', '定西市');
INSERT INTO `enums` VALUES ('1', '31000', '陇南市');
INSERT INTO `enums` VALUES ('1', '31100', '临夏回族自治州');
INSERT INTO `enums` VALUES ('1', '31200', '甘南藏族自治州');
INSERT INTO `enums` VALUES ('1', '31300', '西宁市');
INSERT INTO `enums` VALUES ('1', '31400', '海东市');
INSERT INTO `enums` VALUES ('1', '31500', '海北藏族自治州');
INSERT INTO `enums` VALUES ('1', '31600', '黄南藏族自治州');
INSERT INTO `enums` VALUES ('1', '31700', '海南藏族自治州');
INSERT INTO `enums` VALUES ('1', '31800', '果洛藏族自治州');
INSERT INTO `enums` VALUES ('1', '31900', '玉树藏族自治州');
INSERT INTO `enums` VALUES ('1', '32000', '海西蒙古族藏族自治州');
INSERT INTO `enums` VALUES ('1', '32100', '银川市');
INSERT INTO `enums` VALUES ('1', '32200', '石嘴山市');
INSERT INTO `enums` VALUES ('1', '32300', '吴忠市');
INSERT INTO `enums` VALUES ('1', '32400', '固原市');
INSERT INTO `enums` VALUES ('1', '32500', '中卫市');
INSERT INTO `enums` VALUES ('1', '32600', '乌鲁木齐市');
INSERT INTO `enums` VALUES ('1', '32700', '克拉玛依市');
INSERT INTO `enums` VALUES ('1', '32800', '吐鲁番地区');
INSERT INTO `enums` VALUES ('1', '32900', '哈密地区');
INSERT INTO `enums` VALUES ('1', '33000', '昌吉回族自治州');
INSERT INTO `enums` VALUES ('1', '33100', '博尔塔拉蒙古自治州');
INSERT INTO `enums` VALUES ('1', '33200', '巴音郭楞蒙古自治州');
INSERT INTO `enums` VALUES ('1', '33300', '阿克苏地区');
INSERT INTO `enums` VALUES ('1', '33400', '克孜勒苏柯尔克孜自治州');
INSERT INTO `enums` VALUES ('1', '33500', '喀什地区');
INSERT INTO `enums` VALUES ('1', '33600', '和田地区');
INSERT INTO `enums` VALUES ('1', '33700', '伊犁哈萨克自治州');
INSERT INTO `enums` VALUES ('1', '33800', '塔城地区');
INSERT INTO `enums` VALUES ('1', '33900', '阿勒泰地区');
INSERT INTO `enums` VALUES ('1', '34000', '自治区直辖县级行政区划');
INSERT INTO `enums` VALUES ('1', '34100', '中央支援组');
INSERT INTO `enums` VALUES ('1', '34102', '测试');
INSERT INTO `enums` VALUES ('1', '34200', '深圳市2');
INSERT INTO `enums` VALUES ('1', '34202', '宝安区');
INSERT INTO `enums` VALUES ('1', '34203', '光明区');
INSERT INTO `enums` VALUES ('1', '34300', '惠州市2');
INSERT INTO `enums` VALUES ('1', '34302', '博罗县');
INSERT INTO `enums` VALUES ('1', '34400', '深圳市3');
INSERT INTO `enums` VALUES ('1', '34402', '福田');
INSERT INTO `enums` VALUES ('1', '34500', '深圳市3');
INSERT INTO `enums` VALUES ('2', '0', '');
INSERT INTO `enums` VALUES ('2', '1', '清洁');
INSERT INTO `enums` VALUES ('2', '2', '灭虫');
INSERT INTO `enums` VALUES ('2', '3', '清潔首次');
INSERT INTO `enums` VALUES ('2', '4', '滅蟲首次');
INSERT INTO `enums` VALUES ('2', '5', '滅蟲噴焗');
INSERT INTO `enums` VALUES ('2', '6', '白蟲');
INSERT INTO `enums` VALUES ('2', '7', '蛀蟲');
INSERT INTO `enums` VALUES ('2', '8', '床蝨');
INSERT INTO `enums` VALUES ('2', '9', '居家及企業服務');
INSERT INTO `enums` VALUES ('2', '10', '甲醛處理');
INSERT INTO `enums` VALUES ('2', '11', '飄盈香服務');
INSERT INTO `enums` VALUES ('2', '12', '空氣淨化系統安裝');
INSERT INTO `enums` VALUES ('2', '13', '機具安裝');
INSERT INTO `enums` VALUES ('2', '14', '飄盈香機具安裝');
INSERT INTO `enums` VALUES ('2', '15', '病媒專業證照');
INSERT INTO `enums` VALUES ('2', '16', '飲水機安裝');
INSERT INTO `enums` VALUES ('2', '17', '更換加香劑');
INSERT INTO `enums` VALUES ('2', '18', '檢查滅蠅燈');
INSERT INTO `enums` VALUES ('2', '19', '滯留噴灑');
INSERT INTO `enums` VALUES ('2', '20', '纸品');
INSERT INTO `enums` VALUES ('2', '21', '维修');
INSERT INTO `enums` VALUES ('2', '22', '空间消毒');
INSERT INTO `enums` VALUES ('2', '23', '鼠臭跟进');
INSERT INTO `enums` VALUES ('2', '24', '送皂液');
INSERT INTO `enums` VALUES ('2', '25', '白蚁');
INSERT INTO `enums` VALUES ('2', '26', '更换滤网');
INSERT INTO `enums` VALUES ('2', '27', '检查清洁净化机');
INSERT INTO `enums` VALUES ('3', '0', '');
INSERT INTO `enums` VALUES ('3', '1', '技术部');
INSERT INTO `enums` VALUES ('3', '2', '会计部');
INSERT INTO `enums` VALUES ('3', '3', '营运部');
INSERT INTO `enums` VALUES ('3', '4', '销售部');
INSERT INTO `enums` VALUES ('3', '5', '质检部');
INSERT INTO `enums` VALUES ('3', '6', '总务部');
INSERT INTO `enums` VALUES ('3', '7', '人事部');
INSERT INTO `enums` VALUES ('3', '8', '其他');
INSERT INTO `enums` VALUES ('3', '9', '物流维修部');
INSERT INTO `enums` VALUES ('3', '10', '');
INSERT INTO `enums` VALUES ('3', '11', '中央资源组');
INSERT INTO `enums` VALUES ('3', '12', '总经办');
INSERT INTO `enums` VALUES ('4', '100', '餐饮类');
INSERT INTO `enums` VALUES ('4', '101', '中餐');
INSERT INTO `enums` VALUES ('4', '102', '西餐');
INSERT INTO `enums` VALUES ('4', '103', '网吧');
INSERT INTO `enums` VALUES ('4', '104', '酒吧');
INSERT INTO `enums` VALUES ('4', '105', 'KTV');
INSERT INTO `enums` VALUES ('4', '106', '加工廠');
INSERT INTO `enums` VALUES ('4', '107', '電影院');
INSERT INTO `enums` VALUES ('4', '108', '棋牌');
INSERT INTO `enums` VALUES ('4', '109', '甜点');
INSERT INTO `enums` VALUES ('4', '110', '麵包');
INSERT INTO `enums` VALUES ('4', '111', '江浙菜');
INSERT INTO `enums` VALUES ('4', '112', '火锅');
INSERT INTO `enums` VALUES ('4', '113', '飲品');
INSERT INTO `enums` VALUES ('4', '114', '茶餐厅');
INSERT INTO `enums` VALUES ('4', '115', '咖啡厅');
INSERT INTO `enums` VALUES ('4', '116', '沐足');
INSERT INTO `enums` VALUES ('4', '117', '日本料理');
INSERT INTO `enums` VALUES ('4', '118', '韩国料理');
INSERT INTO `enums` VALUES ('4', '119', '美容院');
INSERT INTO `enums` VALUES ('4', '120', '烧烤');
INSERT INTO `enums` VALUES ('4', '121', '东、西北菜');
INSERT INTO `enums` VALUES ('4', '122', '快/简餐');
INSERT INTO `enums` VALUES ('4', '123', '川/辣菜');
INSERT INTO `enums` VALUES ('4', '124', '其它');
INSERT INTO `enums` VALUES ('4', '125', '泰式');
INSERT INTO `enums` VALUES ('4', '126', '面馆');
INSERT INTO `enums` VALUES ('4', '127', '自助餐');
INSERT INTO `enums` VALUES ('4', '128', '清吧');
INSERT INTO `enums` VALUES ('4', '129', '粤菜');
INSERT INTO `enums` VALUES ('4', '130', '鲁菜');
INSERT INTO `enums` VALUES ('4', '131', '烤肉');
INSERT INTO `enums` VALUES ('4', '200', '非餐饮类');
INSERT INTO `enums` VALUES ('4', '201', '物业');
INSERT INTO `enums` VALUES ('4', '202', '公共厕所');
INSERT INTO `enums` VALUES ('4', '203', '工場');
INSERT INTO `enums` VALUES ('4', '204', '健身室');
INSERT INTO `enums` VALUES ('4', '205', '學校');
INSERT INTO `enums` VALUES ('4', '206', '医院');
INSERT INTO `enums` VALUES ('4', '207', '酒店');
INSERT INTO `enums` VALUES ('4', '208', '公司');
INSERT INTO `enums` VALUES ('4', '209', '培训机构');
INSERT INTO `enums` VALUES ('4', '210', '4S店');
INSERT INTO `enums` VALUES ('4', '211', '商場');
INSERT INTO `enums` VALUES ('4', '212', '銀行');
INSERT INTO `enums` VALUES ('4', '213', '4s店');
INSERT INTO `enums` VALUES ('4', '214', '超市');
INSERT INTO `enums` VALUES ('4', '215', '美髮館');
INSERT INTO `enums` VALUES ('4', '216', '便利店');
INSERT INTO `enums` VALUES ('4', '217', '展館');
INSERT INTO `enums` VALUES ('4', '218', '政府、机关单位');
INSERT INTO `enums` VALUES ('4', '219', '寵物店（醫院）');
INSERT INTO `enums` VALUES ('4', '220', '個人家庭');
INSERT INTO `enums` VALUES ('4', '221', '瑜伽中心');
INSERT INTO `enums` VALUES ('4', '222', '相館影樓');
INSERT INTO `enums` VALUES ('4', '223', '证券所');
INSERT INTO `enums` VALUES ('4', '224', '商店');
INSERT INTO `enums` VALUES ('4', '225', '食堂');
INSERT INTO `enums` VALUES ('4', '226', '运动体育馆');
INSERT INTO `enums` VALUES ('4', '227', '健身中心');
INSERT INTO `enums` VALUES ('4', '228', '游乐场');
INSERT INTO `enums` VALUES ('4', '229', '水疗会所');
INSERT INTO `enums` VALUES ('4', '230', '房地产');
INSERT INTO `enums` VALUES ('4', '231', '美容院');
INSERT INTO `enums` VALUES ('4', '232', '棋牌室');
INSERT INTO `enums` VALUES ('4', '233', '电影院');
INSERT INTO `enums` VALUES ('4', '234', '月子中心');
INSERT INTO `enums` VALUES ('4', '235', '仓库');
INSERT INTO `enums` VALUES ('4', '236', '图书馆');
INSERT INTO `enums` VALUES ('4', '237', '书店');
INSERT INTO `enums` VALUES ('4', '238', '动物园');
INSERT INTO `enums` VALUES ('4', '239', '母婴店');
INSERT INTO `enums` VALUES ('4', '240', '网吧');
INSERT INTO `enums` VALUES ('4', '300', '其他');
INSERT INTO `enums` VALUES ('4', '400', '家居类');
INSERT INTO `enums` VALUES ('4', '401', '家居');
INSERT INTO `enums` VALUES ('5', '1', '30天');
INSERT INTO `enums` VALUES ('5', '2', '45天');
INSERT INTO `enums` VALUES ('5', '3', '60天');
INSERT INTO `enums` VALUES ('5', '4', '转账');
INSERT INTO `enums` VALUES ('5', '5', '即日');
INSERT INTO `enums` VALUES ('5', '6', '现金');
INSERT INTO `enums` VALUES ('5', '7', '10天');
INSERT INTO `enums` VALUES ('5', '8', '90天');
INSERT INTO `enums` VALUES ('5', '9', '180天');
INSERT INTO `enums` VALUES ('5', '10', '365天');
INSERT INTO `enums` VALUES ('5', '11', '5天');
INSERT INTO `enums` VALUES ('5', '12', '7天');
INSERT INTO `enums` VALUES ('5', '13', '15天');
INSERT INTO `enums` VALUES ('5', '14', '20天');
INSERT INTO `enums` VALUES ('5', '15', '货到收款');
INSERT INTO `enums` VALUES ('5', '16', '3天');
INSERT INTO `enums` VALUES ('5', '17', '25天');
INSERT INTO `enums` VALUES ('6', '1', '-');
INSERT INTO `enums` VALUES ('6', '2', '-');
INSERT INTO `enums` VALUES ('6', '3', '-');
INSERT INTO `enums` VALUES ('6', '4', '-');
INSERT INTO `enums` VALUES ('6', '5', '月结（现金）');
INSERT INTO `enums` VALUES ('6', '6', '月结（转账）');
INSERT INTO `enums` VALUES ('6', '7', '季付（现金）');
INSERT INTO `enums` VALUES ('6', '8', '预付九个月（现金）');
INSERT INTO `enums` VALUES ('6', '9', '预付一个月（现金）');
INSERT INTO `enums` VALUES ('6', '10', '预付二个月（现金）');
INSERT INTO `enums` VALUES ('6', '11', '預付三個月（現金）');
INSERT INTO `enums` VALUES ('6', '12', '預付半年（現金）');
INSERT INTO `enums` VALUES ('6', '13', '預付一年（現金）');
INSERT INTO `enums` VALUES ('6', '14', '-');
INSERT INTO `enums` VALUES ('6', '15', '-');
INSERT INTO `enums` VALUES ('6', '16', '-');
INSERT INTO `enums` VALUES ('6', '17', '月结');
INSERT INTO `enums` VALUES ('6', '18', '预付');
INSERT INTO `enums` VALUES ('6', '19', '预付一个月（转账）');
INSERT INTO `enums` VALUES ('6', '20', '预付三个月');
INSERT INTO `enums` VALUES ('6', '21', '预付三个月(转账）');
INSERT INTO `enums` VALUES ('6', '22', '预付四个月');
INSERT INTO `enums` VALUES ('6', '23', '预付二个月（转账)');
INSERT INTO `enums` VALUES ('6', '24', '预付一年（转账）');
INSERT INTO `enums` VALUES ('6', '25', '预付半年（转账）');
INSERT INTO `enums` VALUES ('6', '26', '季度结');
INSERT INTO `enums` VALUES ('6', '27', '半年后付（转账）');
INSERT INTO `enums` VALUES ('6', '28', '现金');
INSERT INTO `enums` VALUES ('6', '29', '转账');
INSERT INTO `enums` VALUES ('6', '30', '当月开票付款');
INSERT INTO `enums` VALUES ('7', '1', '清洁问题');
INSERT INTO `enums` VALUES ('7', '2', '灭虫问题');
INSERT INTO `enums` VALUES ('8', '1', 'GZ');
INSERT INTO `enums` VALUES ('8', '2', 'ZH');
INSERT INTO `enums` VALUES ('8', '3', 'SH');
INSERT INTO `enums` VALUES ('8', '4', 'ZS');
INSERT INTO `enums` VALUES ('8', '5', 'FS');
INSERT INTO `enums` VALUES ('8', '6', 'BJ');
INSERT INTO `enums` VALUES ('8', '7', 'SZ');
INSERT INTO `enums` VALUES ('8', '8', 'NN');
INSERT INTO `enums` VALUES ('8', '9', 'CD');
INSERT INTO `enums` VALUES ('8', '10', 'FZ');
INSERT INTO `enums` VALUES ('8', '11', 'DG');
INSERT INTO `enums` VALUES ('8', '12', 'JM');
INSERT INTO `enums` VALUES ('8', '13', 'NJ');
INSERT INTO `enums` VALUES ('8', '14', 'ZY');
INSERT INTO `enums` VALUES ('8', '15', 'CQ');
INSERT INTO `enums` VALUES ('8', '16', 'XA');
INSERT INTO `enums` VALUES ('8', '17', 'WH');
INSERT INTO `enums` VALUES ('8', '18', 'TJ');
INSERT INTO `enums` VALUES ('8', '19', 'WX');
INSERT INTO `enums` VALUES ('8', '20', 'HZ');
INSERT INTO `enums` VALUES ('8', '21', 'CS');

-- ----------------------------
-- Table structure for `lbs_report_autograph`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_report_autograph`;
CREATE TABLE `lbs_report_autograph` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务id(工作单或跟进单id)',
  `job_type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务类型编号（1-工作单，2跟进单）',
  `employee_signature` longtext COLLATE utf8_unicode_ci COMMENT '员工签名',
  `customer_signature` longtext COLLATE utf8_unicode_ci COMMENT '客户签名',
  `customer_grade` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '客户点评',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_report_autograph
-- ----------------------------
INSERT INTO `lbs_report_autograph` VALUES ('1', '950174', '1', '', 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iNjUzLjU5Mzc1IiBoZWlnaHQ9IjI5MyI+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjMiIHN0cm9rZT0icmdiKDAsMCwwKSIgZmlsbD0ibm9uZSIgZD0iTSA0ODUgMTE1LjUgTCA0ODUgMTE1LjUgTCA0ODIuMyAxMTYgTCA0ODEuMyAxMTYgTCA0ODMgMTE2IEwgNDgxIDExNiBMIDQ4MSAxMTYgTCA0ODEgMTE2IEwgNDgwIDExNiBMIDQ4MyAxMTYgTCA0ODMgMTE2IEwgNDgyIDExNiBMIDQ4MyAxMTYgTCA0ODIgMTE2IEwgNDgwIDExNiBMIDQ3OCAxMTYgTCA0ODEgMTE2IEwgNDc4IDExNiBMIDQ3OCAxMTcgTCA0NzUgMTE3IEwgNDc0IDExOCBMIDQ3NCAxMTggTCA0NzkgMTE4IEwgNDc3IDExOSBMIDQ3NCAxMTkgTCA0NzMgMTIxIEwgNDcwIDEyMSBMIDQ3NiAxMjEgTCA0NzMgMTIyIEwgNDc4IDEyMyBMIDQ3NSAxMjUgTCA0NzYgMTI1IEwgNDc0IDEyNiBMIDQ4MiAxMjYgTCA0ODQgMTI2IEwgNDg1IDEyNiIvPgo8cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMyIgc3Ryb2tlPSJyZ2IoMCwwLDApIiBmaWxsPSJub25lIiBkPSJNIDM1NyAxMTkuNSBMIDM1NyAxMTkuNSBMIDM1Ny4zIDExNyBMIDM1Ni4zIDExNS41IEwgMzU3IDExOC41IEwgMzU3IDExNy41IEwgMzU1IDExNy41IEwgMzU1IDExNS41IEwgMzU3IDExNy41IEwgMzU2IDExNS41IEwgMzU2IDExNS41IEwgMzU1IDExMC41IEwgMzU2IDExNi41IEwgMzU1IDExNS41IEwgMzU2IDExOC41IEwgMzU3IDExOC41IEwgMzU3IDExOS41Ii8+CjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIzIiBzdHJva2U9InJnYigwLDAsMCkiIGZpbGw9Im5vbmUiIGQ9Ik0gMzQ0LjggMTc1LjMgTCAzNDQuOCAxNzUuMyBMIDMzOSAxNDcuNSIvPgo8cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMyIgc3Ryb2tlPSJyZ2IoMCwwLDApIiBmaWxsPSJub25lIiBkPSJNIDQxMSAxNjEuNSBMIDQxMSAxNjEuNSBMIDQxMSAxNjEuNSIvPgo8cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMyIgc3Ryb2tlPSJyZ2IoMCwwLDApIiBmaWxsPSJub25lIiBkPSJNIDUxOCAxOTIuNSBMIDUxOCAxOTIuNSBMIDUxOCAxOTIuNSIvPgo8cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMyIgc3Ryb2tlPSJyZ2IoMCwwLDApIiBmaWxsPSJub25lIiBkPSJNIDMzOSAxNTkuNSBMIDMzOSAxNTkuNSBMIDM0MS4zIDE1OSBMIDM0Ni4zIDE1OSBMIDM1MC4zIDE1OSBMIDM1Ni4zIDE1NyBMIDM2MC4zIDE1NyBMIDM2NS4zIDE1NiBMIDM2OS4zIDE1NiBMIDM3Mi4zIDE1NSBMIDM3Ni4zIDE1NSBMIDM4MS4zIDE1NSBMIDM4NS4zIDE1NSBMIDM4OS4zIDE1NCBMIDM5NC4zIDE1NCBMIDM5Ny4zIDE1NCBMIDM5OC4zIDE1NCBMIDQwMC4zIDE1NCBMIDQwMS4zIDE1NCBMIDQwMi4zIDE1NCBMIDQwMy4zIDE1NCBMIDQwNC4zIDE1NCBMIDQwNS4zIDE1NCBMIDQwNi4zIDE1NCBMIDQwNy4zIDE1NCBMIDQwOC4zIDE1NCBMIDQxMC4zIDE1NCBMIDQxMy4zIDE1NCBMIDQxNC4zIDE1NCBMIDQxNy4zIDE1NCBMIDQyMS4zIDE1NCBMIDQyNS4zIDE1NCBMIDQzMS4zIDE1MyBMIDQzNi4zIDE1MiBMIDQ0My4zIDE1MiBMIDQ0OC4zIDE1MiBMIDQ1NC4zIDE1MiBMIDQ1Ny4zIDE1MiBMIDQ1OS4zIDE1MiBMIDQ2MS4zIDE1MiBMIDQ2Mi4zIDE1MiBMIDQ2NS4zIDE1MiBMIDQ2Ni4zIDE1MiBMIDQ2OC4zIDE1MiBMIDQ2OS4zIDE1MiBMIDQ3MS4zIDE1MiBMIDQ3My4zIDE1MiBMIDQ3Ny4zIDE1MyBMIDQ3Ny4zIDE1MyIvPjwvc3ZnPg==', '5', '2021-09-16 12:58:17');

-- ----------------------------
-- Table structure for `lbs_service_briefings`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_briefings`;
CREATE TABLE `lbs_service_briefings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '服务id(工作单或跟进单id)',
  `job_type` int(1) DEFAULT NULL COMMENT '服务类型（1-工作单，2跟进单）',
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务内容',
  `proposal` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lbs_service_briefings
-- ----------------------------
INSERT INTO `lbs_service_briefings` VALUES ('7', '950174', '1', '建议：食材加盖或密封存放，以降低虫害的取食率', '建议：食材加盖或密封存放，以降低虫害的取食率', '2021-08-30 11:53:55');

-- ----------------------------
-- Table structure for `lbs_service_employee_signature`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_employee_signature`;
CREATE TABLE `lbs_service_employee_signature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(50) DEFAULT NULL,
  `staffid` varchar(50) DEFAULT NULL,
  `signature` longtext,
  `creat_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lbs_service_employee_signature
-- ----------------------------

-- ----------------------------
-- Table structure for `lbs_service_equipments`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_equipments`;
CREATE TABLE `lbs_service_equipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务id(工作单或跟进单id)',
  `job_type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务类型编号（1-工作单，2跟进单）',
  `equipment_type_id` int(11) DEFAULT '0' COMMENT '设备类型id',
  `equipment_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '设备名称',
  `equipment_area` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '设备区域',
  `check_datas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '检查数据{"苍蝇":11,"蚊子":2}',
  `site_photos` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '现场照片：{，}',
  `check_handle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '检查与处理:设备更换，清洁等{}',
  `more_info` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '补充说明',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_equipments
-- ----------------------------
INSERT INTO `lbs_service_equipments` VALUES ('35', '950174', '1', '3', '灭蝇灯', '生产区', '[{\"label\":\"苍蝇\",\"value\":1},{\"label\":\"文字\",\"value\":1},{\"label\":\"蛾类\",\"value\":1}]', 'undefined,\"\\/storage\\/img\\/20210915\\/ca85a1002b1a32d9ada9ec996f25a4da.png\",\"\\/storage\\/img\\/20210915\\/ab79d2b29d7a8955ff3efcbc77632fd9.png\"', '设备异常,更换灯罩', 'hkl,', '2021-09-15 15:25:00');
INSERT INTO `lbs_service_equipments` VALUES ('36', '950174', '1', '4', '粘鼠板', '仓库', '[{\"label\":\"鼠\",\"value\":1}]', '\"\\/storage\\/img\\/20210915\\/83c3e2c95bc1df39e7d6315ee4df40c1.png\",\"\\/storage\\/img\\/20210915\\/cb9c50a98a8e50b9cf75f407ef5c11b6.png\"', '更换粘板', 'gfsg', '2021-09-15 15:28:54');
INSERT INTO `lbs_service_equipments` VALUES ('37', '950174', '1', '6', '清新机', '生产区', '[{\"label\":\"香型\",\"selects\":[{\"label\":\"春天\",\"value\":\"春天\"},{\"label\":\"柠檬\",\"value\":\"柠檬\"}],\"value\":\"春天\"}]', '\"\\/storage\\/img\\/20210916\\/32cfea46b6e96e52069e2ec59181c69c.png\",\"\\/storage\\/img\\/20210916\\/6630595f9ddf86fd465dcee825b5e968.png\"', '设备异常', '检查粘鼠板，未发现鼠痕迹做清洁、更换粘鼠板处理。检查布放的蟑螂屋，未发现蟑螂痕迹，做清洁、更换粘板处理。', '2021-09-16 15:11:58');

-- ----------------------------
-- Table structure for `lbs_service_equipment_type`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_equipment_type`;
CREATE TABLE `lbs_service_equipment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '城市（CD）',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '设备名称：灭蝇灯',
  `type` int(11) DEFAULT NULL COMMENT '设备类型（1-数量输入，2-数据输入）',
  `check_targt` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '检查害虫：苍蝇，蚊子',
  `check_handles` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '检查与处理:设备更换，清洁等',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_equipment_type
-- ----------------------------
INSERT INTO `lbs_service_equipment_type` VALUES ('3', 'ZS', '灭蝇灯', '1', '苍蝇,文字,蛾类', '设备更换,设备异常,清洁,更换灯管,更换灯罩', '2021-08-30 11:29:31');
INSERT INTO `lbs_service_equipment_type` VALUES ('4', 'ZS', '粘鼠板', '1', '鼠', '更换粘板', '2021-08-30 11:29:50');
INSERT INTO `lbs_service_equipment_type` VALUES ('5', 'ZS', '蟑螂屋', '1', '蟑螂,苍蝇,文字,蛾类', '设备更换', '2021-08-30 11:30:23');
INSERT INTO `lbs_service_equipment_type` VALUES ('6', 'ZS', '清新机', '2', '香型,范围', '设备更换,设备异常,清洁', '2021-08-30 11:34:59');
INSERT INTO `lbs_service_equipment_type` VALUES ('7', 'ZS', '是', '2', 'ceshi,shi', '', '2021-09-16 17:05:06');

-- ----------------------------
-- Table structure for `lbs_service_equipment_type_selects`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_equipment_type_selects`;
CREATE TABLE `lbs_service_equipment_type_selects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_type_id` int(50) DEFAULT NULL COMMENT '设备类型id',
  `check_targt` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '检查：香型，剩余量等',
  `check_selects` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '下拉选择:白玉兰，等',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_equipment_type_selects
-- ----------------------------
INSERT INTO `lbs_service_equipment_type_selects` VALUES ('2', '6', '1', '春天,柠檬', '2021-08-30 11:35:21');
INSERT INTO `lbs_service_equipment_type_selects` VALUES ('4', '7', '0', 'sad,sgd,hj', '2021-09-17 15:04:47');

-- ----------------------------
-- Table structure for `lbs_service_materials`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_materials`;
CREATE TABLE `lbs_service_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务id(工作单或跟进单id)',
  `job_type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务类型编号（1-工作单，2跟进单）',
  `material_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '物料名称',
  `material_registration_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '农药登记证号',
  `material_active_ingredient` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '有效成分',
  `material_ratio` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '物料配比',
  `targets` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '靶标',
  `use_mode` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '使用方式',
  `use_area` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '使用区域',
  `processing_space` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '处理空间',
  `dosage` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '药物用量(多少克，几张)',
  `matters_needing_attention` varchar(2255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '注意事项',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lbs_service_materials
-- ----------------------------
INSERT INTO `lbs_service_materials` VALUES ('6', '950174', '1', '速克力（500g）', 'WP20180103', '40%呋虫胺', '·1', '蟑螂,苍蝇,果蝇', '滞留喷洒,直接使用', '用餐区,冰箱', '1', '1', '1', '2021-09-09 11:25:37');

-- ----------------------------
-- Table structure for `lbs_service_material_classifys`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_material_classifys`;
CREATE TABLE `lbs_service_material_classifys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '城市（CD）',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '分类名称',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lbs_service_material_classifys
-- ----------------------------
INSERT INTO `lbs_service_material_classifys` VALUES ('6', 'ZS', '药饵', '2021-08-30 11:17:58');
INSERT INTO `lbs_service_material_classifys` VALUES ('5', 'ZS', '药剂', '2021-08-30 11:17:49');
INSERT INTO `lbs_service_material_classifys` VALUES ('7', 'ZS', '检测', '2021-08-30 11:18:05');
INSERT INTO `lbs_service_material_classifys` VALUES ('8', 'ZS', '消毒', '2021-08-30 11:18:10');

-- ----------------------------
-- Table structure for `lbs_service_material_lists`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_material_lists`;
CREATE TABLE `lbs_service_material_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '物料名称',
  `classify_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '分类ID',
  `registration_no` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '登记证号',
  `validity` datetime DEFAULT NULL COMMENT '有效期',
  `active_ingredient` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '有效成分',
  `ratio` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '物料配比',
  `brief` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '简介',
  `unit` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '单位(克、个之类的)',
  `sort` int(100) DEFAULT NULL COMMENT '排序（1--）',
  `status` int(1) DEFAULT '1' COMMENT 'int(1-是，0-否)',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lbs_service_material_lists
-- ----------------------------
INSERT INTO `lbs_service_material_lists` VALUES ('4', '粘鼠板', '7', '', '2021-10-11 00:00:00', '', '', '', '张', '11', '1', '2021-08-30 11:42:31');
INSERT INTO `lbs_service_material_lists` VALUES ('5', '都灭', '5', 'WP20100108', '2025-08-09 00:00:00', '顺式氯氰菊酯', '-', '', '毫升', '1', '1', '2021-08-30 11:47:23');
INSERT INTO `lbs_service_material_lists` VALUES ('6', '灭蟑清', '6', 'WP20110146', '2021-06-15 00:00:00', '氟虫腈 0.05%', '', '', '毫升', '1', '1', '2021-08-30 11:47:43');
INSERT INTO `lbs_service_material_lists` VALUES ('7', '速克力（500g）', '5', 'WP20180103', '2023-05-16 00:00:00', '40%呋虫胺', '', '', '克', '1', '1', '2021-08-30 11:48:35');

-- ----------------------------
-- Table structure for `lbs_service_material_target_lists`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_material_target_lists`;
CREATE TABLE `lbs_service_material_target_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '城市（CD）',
  `service_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务类型',
  `targets` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '靶标：害虫,蚊子,',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_material_target_lists
-- ----------------------------
INSERT INTO `lbs_service_material_target_lists` VALUES ('4', 'ZS', '2', '老鼠,蟑螂,苍蝇,果蝇', '2021-08-30 11:19:26');
INSERT INTO `lbs_service_material_target_lists` VALUES ('5', 'ZS', '3', '白蚁', '2021-08-30 11:21:27');

-- ----------------------------
-- Table structure for `lbs_service_material_use_modes`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_material_use_modes`;
CREATE TABLE `lbs_service_material_use_modes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '城市（CD）',
  `use_mode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '方式如：直接使用，空间处理等',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_material_use_modes
-- ----------------------------
INSERT INTO `lbs_service_material_use_modes` VALUES ('4', 'ZS', '直接投放', '2021-08-30 11:18:23');
INSERT INTO `lbs_service_material_use_modes` VALUES ('5', 'ZS', '直接使用', '2021-08-30 11:18:30');
INSERT INTO `lbs_service_material_use_modes` VALUES ('6', 'ZS', '滞留喷洒', '2021-08-30 11:18:36');
INSERT INTO `lbs_service_material_use_modes` VALUES ('7', 'ZS', '空间处理', '2021-08-30 11:18:41');

-- ----------------------------
-- Table structure for `lbs_service_photos`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_photos`;
CREATE TABLE `lbs_service_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务id(工作单或跟进单id)',
  `job_type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务类型编号（1-工作单，2跟进单）',
  `site_photos` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '现场照片',
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注说明',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_photos
-- ----------------------------
INSERT INTO `lbs_service_photos` VALUES ('6', '950174', '1', '\"\\/storage\\/img\\/20210915\\/977c7eccdd98435f258325eaeb33109c.png\"', '1', '2021-09-13 17:00:53');
INSERT INTO `lbs_service_photos` VALUES ('7', '950174', '1', '\"\\/storage\\/img\\/20210915\\/9dc7f596fc14a959521ba9ec799c4e0a.png\",\"\\/storage\\/img\\/20210915\\/133ec0793bc736005788e3387bde417d.png\"', 'sfgv', '2021-09-15 15:26:30');

-- ----------------------------
-- Table structure for `lbs_service_risks`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_risks`;
CREATE TABLE `lbs_service_risks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务id(工作单或跟进单id)',
  `job_type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务类型编号（1-工作单，2跟进单）',
  `risk_targets` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '靶标',
  `risk_types` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '风险类别',
  `risk_rank` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '风险等级',
  `risk_label` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '风险标签',
  `site_photos` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '现场照片',
  `risk_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '风险描述',
  `risk_proposal` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '整改建议',
  `take_steps` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '采取措施',
  `follow_times` int(11) DEFAULT '0' COMMENT '跟进次数',
  `follow_id` int(11) DEFAULT '0' COMMENT '跟进id',
  `status` int(1) DEFAULT '0' COMMENT '状态（0-未解决，1已解决，2跟进中）',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_risks
-- ----------------------------
INSERT INTO `lbs_service_risks` VALUES ('3', '950174', '1', '德国小蠊', '外围压力', '高', '已多次提及，未有效跟进', '\"\\/storage\\/img\\/20210914\\/9cd817dac809877786f704e943fa65d0.png\",\"\\/storage\\/img\\/20210915\\/e2fe8faa53b2e08dc5e8004adc3c2cf7.png\"', '算', '是', '算', '0', '0', '0', '2021-09-09 11:38:06');
INSERT INTO `lbs_service_risks` VALUES ('4', '950173', '1', '褐家鼠,黄胸鼠', '卫生清洁', '高', '新发现', '\"\\/storage\\/img\\/20210914\\/5f222d46b02530d3fee82c727fad941b.png\"', '测试', '测试', '测试', '0', '11', '2', '2021-09-09 15:01:47');
INSERT INTO `lbs_service_risks` VALUES ('5', '950172', '1', '啊', '啊', '啊', '是', '\"\\/storage\\/img\\/20210914\\/5f222d46b02530d3fee82c727fad941b.png\"', null, null, null, '0', '0', '1', null);
INSERT INTO `lbs_service_risks` VALUES ('6', '950172', '1', '的', '发', '发', null, '\"\\/storage\\/img\\/20210914\\/5f222d46b02530d3fee82c727fad941b.png\"', null, null, null, '0', '13', '2', null);
INSERT INTO `lbs_service_risks` VALUES ('12', '950174', '1', '褐家鼠', '结构设施', '高', '已多次提及，未有效跟进', '\"\\/storage\\/img\\/20210914\\/afbd469f6209668df5774906da51d211.png\",\"\\/storage\\/img\\/20210914\\/b3599ffc61614d32f530ea00b457c6b3.png\"', '2', '3', '4', '0', '0', '0', '2021-09-14 14:43:28');
INSERT INTO `lbs_service_risks` VALUES ('14', '950174', '1', '小家鼠', '卫生清洁', '高', '持续发现项', '\"\\/storage\\/img\\/20210915\\/8979af922ba3579c7f1b299d6a2411c1.png\",\"\\/storage\\/img\\/20210915\\/d77dd193e66b56c1a69220451ea6520b.png\"', 'a', 'a', 'a', '0', '0', '0', '2021-09-15 15:27:15');
INSERT INTO `lbs_service_risks` VALUES ('13', '950174', '1', '的', '发', '发', null, '\"\\/storage\\/img\\/20210914\\/5f222d46b02530d3fee82c727fad941b.png\"', null, null, null, '1', '0', '0', '2021-09-14 16:44:51');

-- ----------------------------
-- Table structure for `lbs_service_risk_label_lists`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_risk_label_lists`;
CREATE TABLE `lbs_service_risk_label_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '风险标签：新发现，持续关注，',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_risk_label_lists
-- ----------------------------
INSERT INTO `lbs_service_risk_label_lists` VALUES ('3', '新发现', '2021-08-30 11:24:26');
INSERT INTO `lbs_service_risk_label_lists` VALUES ('4', '持续发现项', '2021-08-30 11:24:33');
INSERT INTO `lbs_service_risk_label_lists` VALUES ('5', '已多次提及，未有效跟进', '2021-08-30 11:24:48');

-- ----------------------------
-- Table structure for `lbs_service_risk_rank_lists`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_risk_rank_lists`;
CREATE TABLE `lbs_service_risk_rank_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '风险等级：高，中，低',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_risk_rank_lists
-- ----------------------------
INSERT INTO `lbs_service_risk_rank_lists` VALUES ('1', '高', '2021-08-20 16:11:09');
INSERT INTO `lbs_service_risk_rank_lists` VALUES ('2', '中', '2021-08-20 16:11:12');
INSERT INTO `lbs_service_risk_rank_lists` VALUES ('3', '低', '2021-08-20 16:11:14');

-- ----------------------------
-- Table structure for `lbs_service_risk_target_lists`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_risk_target_lists`;
CREATE TABLE `lbs_service_risk_target_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '城市（CD）',
  `target` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '靶标：害虫',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_risk_target_lists
-- ----------------------------
INSERT INTO `lbs_service_risk_target_lists` VALUES ('2', 'ZS', '褐家鼠', '2021-08-30 11:22:45');
INSERT INTO `lbs_service_risk_target_lists` VALUES ('3', 'ZS', '黄胸鼠', '2021-08-30 11:22:52');
INSERT INTO `lbs_service_risk_target_lists` VALUES ('4', 'ZS', '小家鼠', '2021-08-30 11:22:58');
INSERT INTO `lbs_service_risk_target_lists` VALUES ('5', 'ZS', '德国小蠊', '2021-08-30 11:23:04');
INSERT INTO `lbs_service_risk_target_lists` VALUES ('6', 'ZS', '家蝇', '2021-08-30 11:23:15');

-- ----------------------------
-- Table structure for `lbs_service_risk_type_lists`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_risk_type_lists`;
CREATE TABLE `lbs_service_risk_type_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '城市（CD）',
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '风险类型：结构设施，卫生清洁等',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_risk_type_lists
-- ----------------------------
INSERT INTO `lbs_service_risk_type_lists` VALUES ('4', 'ZS', '结构设施', '2021-08-30 11:23:26');
INSERT INTO `lbs_service_risk_type_lists` VALUES ('5', 'ZS', '卫生清洁', '2021-08-30 11:23:33');
INSERT INTO `lbs_service_risk_type_lists` VALUES ('6', 'ZS', '外围压力', '2021-08-30 11:23:39');
INSERT INTO `lbs_service_risk_type_lists` VALUES ('7', 'ZS', '日常管理', '2021-08-30 11:23:44');

-- ----------------------------
-- Table structure for `lbs_service_shortcuts`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_shortcuts`;
CREATE TABLE `lbs_service_shortcuts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '城市代码（CD）',
  `shortcut_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '快捷语类型（briefing，material，equipment，risk，photo）',
  `shortcut_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '快捷语名称（服务简报，物料使用，设备情况，风险跟进，现场工作照）',
  `service_type` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务类型(服务类型不同快捷语不同)',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lbs_service_shortcuts
-- ----------------------------
INSERT INTO `lbs_service_shortcuts` VALUES ('8', 'ZS', 'briefing', '服务简报', '2', '2021-08-30 11:25:53');
INSERT INTO `lbs_service_shortcuts` VALUES ('9', 'ZS', 'material', '物料使用', '2', '2021-08-30 11:26:03');
INSERT INTO `lbs_service_shortcuts` VALUES ('10', 'ZS', 'equipment', '设备情况', '2', '2021-08-30 11:26:24');
INSERT INTO `lbs_service_shortcuts` VALUES ('11', 'ZS', 'risk', '风险跟进', '2', '2021-08-30 11:26:33');
INSERT INTO `lbs_service_shortcuts` VALUES ('12', 'ZS', 'photo', '现场工作照', '2', '2021-08-30 11:26:41');

-- ----------------------------
-- Table structure for `lbs_service_shortcut_contents`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_shortcut_contents`;
CREATE TABLE `lbs_service_shortcut_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortcut_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '快捷语类型',
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '内容',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_shortcut_contents
-- ----------------------------
INSERT INTO `lbs_service_shortcut_contents` VALUES ('3', '8', '建议：定期清理虫害尸体/粪便', '2021-08-30 11:26:49');
INSERT INTO `lbs_service_shortcut_contents` VALUES ('4', '9', '为保证防治效果，请不要随意丢弃我司布防的果蝇杯', '2021-08-30 11:26:56');
INSERT INTO `lbs_service_shortcut_contents` VALUES ('5', '10', '不要随意占用灭蝇灯插座，并保持灭蝇灯处于24小时通电运作', '2021-08-30 11:27:04');
INSERT INTO `lbs_service_shortcut_contents` VALUES ('6', '11', '建议垃圾桶加盖，做到垃圾一天一清，防止小飞虫滋生', '2021-08-30 11:27:10');
INSERT INTO `lbs_service_shortcut_contents` VALUES ('7', '8', '建议：食材加盖或密封存放，以降低虫害的取食率', '2021-08-30 11:27:20');
INSERT INTO `lbs_service_shortcut_contents` VALUES ('8', '11', '建议厨房货架上摆放的物品不要太高，避免老鼠通过天花和货架侵入', '2021-08-30 11:27:38');
INSERT INTO `lbs_service_shortcut_contents` VALUES ('9', '12', '捕获美洲大蠊；', '2021-08-30 11:28:02');
INSERT INTO `lbs_service_shortcut_contents` VALUES ('10', '12', '捕获德国小蠊；', '2021-08-30 11:28:09');
INSERT INTO `lbs_service_shortcut_contents` VALUES ('11', '10', '检查粘鼠板，未发现鼠痕迹做清洁、更换粘鼠板处理。检查布放的蟑螂屋，未发现蟑螂痕迹，做清洁、更换粘板处理。', '2021-08-30 11:28:17');
INSERT INTO `lbs_service_shortcut_contents` VALUES ('12', '9', '地面及墙角已进行药物处理，请勿在当天进行冲洗，以免药物失效。', '2021-08-30 11:28:32');

-- ----------------------------
-- Table structure for `lbs_service_use_areas`
-- ----------------------------
DROP TABLE IF EXISTS `lbs_service_use_areas`;
CREATE TABLE `lbs_service_use_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '城市代码（CD）',
  `area_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '物料使用(material)，设备放置区域(equipment)',
  `use_area` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '区域如：厨房，冰箱',
  `creat_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of lbs_service_use_areas
-- ----------------------------
INSERT INTO `lbs_service_use_areas` VALUES ('3', 'ZS', 'material', '厨房', '2021-08-30 11:35:45');
INSERT INTO `lbs_service_use_areas` VALUES ('4', 'ZS', 'material', '用餐区', '2021-08-30 11:35:52');
INSERT INTO `lbs_service_use_areas` VALUES ('5', 'ZS', 'material', '冰箱', '2021-08-30 11:36:10');
INSERT INTO `lbs_service_use_areas` VALUES ('6', 'ZS', 'material', '仓库', '2021-08-30 11:36:16');
INSERT INTO `lbs_service_use_areas` VALUES ('7', 'ZS', 'material', '下水道', '2021-08-30 11:36:21');
INSERT INTO `lbs_service_use_areas` VALUES ('8', 'ZS', 'equipment', '更衣室', '2021-08-30 11:37:03');
INSERT INTO `lbs_service_use_areas` VALUES ('9', 'ZS', 'equipment', '生产区', '2021-08-30 11:37:11');
INSERT INTO `lbs_service_use_areas` VALUES ('10', 'ZS', 'equipment', '仓库', '2021-08-30 11:37:18');
INSERT INTO `lbs_service_use_areas` VALUES ('11', 'ZS', 'equipment', '研发室', '2021-08-30 11:37:24');

-- ----------------------------
-- Table structure for `officecity`
-- ----------------------------
DROP TABLE IF EXISTS `officecity`;
CREATE TABLE `officecity` (
  `Office` int(11) NOT NULL,
  `City` int(11) NOT NULL,
  UNIQUE KEY `City` (`City`),
  KEY `Office` (`Office`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of officecity
-- ----------------------------
INSERT INTO `officecity` VALUES ('1', '19700');
INSERT INTO `officecity` VALUES ('2', '20000');
INSERT INTO `officecity` VALUES ('3', '300');
INSERT INTO `officecity` VALUES ('4', '20100');
INSERT INTO `officecity` VALUES ('4', '20600');
INSERT INTO `officecity` VALUES ('4', '21400');
INSERT INTO `officecity` VALUES ('4', '21700');
INSERT INTO `officecity` VALUES ('5', '20200');
INSERT INTO `officecity` VALUES ('6', '100');
INSERT INTO `officecity` VALUES ('6', '500');
INSERT INTO `officecity` VALUES ('6', '1400');
INSERT INTO `officecity` VALUES ('6', '2700');
INSERT INTO `officecity` VALUES ('6', '3400');
INSERT INTO `officecity` VALUES ('6', '3900');
INSERT INTO `officecity` VALUES ('6', '15200');
INSERT INTO `officecity` VALUES ('7', '1600');
INSERT INTO `officecity` VALUES ('7', '12400');
INSERT INTO `officecity` VALUES ('7', '12700');
INSERT INTO `officecity` VALUES ('7', '19900');
INSERT INTO `officecity` VALUES ('7', '20700');
INSERT INTO `officecity` VALUES ('8', '21800');
INSERT INTO `officecity` VALUES ('8', '21900');
INSERT INTO `officecity` VALUES ('8', '22000');
INSERT INTO `officecity` VALUES ('8', '22200');
INSERT INTO `officecity` VALUES ('8', '22300');
INSERT INTO `officecity` VALUES ('8', '22600');
INSERT INTO `officecity` VALUES ('8', '22700');
INSERT INTO `officecity` VALUES ('8', '22900');
INSERT INTO `officecity` VALUES ('9', '23600');
INSERT INTO `officecity` VALUES ('9', '24300');
INSERT INTO `officecity` VALUES ('9', '24600');
INSERT INTO `officecity` VALUES ('10', '11500');
INSERT INTO `officecity` VALUES ('10', '11700');
INSERT INTO `officecity` VALUES ('11', '21300');
INSERT INTO `officecity` VALUES ('11', '34200');
INSERT INTO `officecity` VALUES ('11', '34300');
INSERT INTO `officecity` VALUES ('12', '20300');
INSERT INTO `officecity` VALUES ('12', '34400');
INSERT INTO `officecity` VALUES ('13', '7500');
INSERT INTO `officecity` VALUES ('13', '8500');
INSERT INTO `officecity` VALUES ('13', '9900');
INSERT INTO `officecity` VALUES ('14', '34100');
INSERT INTO `officecity` VALUES ('15', '400');
INSERT INTO `officecity` VALUES ('16', '28900');
INSERT INTO `officecity` VALUES ('16', '29100');
INSERT INTO `officecity` VALUES ('16', '29200');
INSERT INTO `officecity` VALUES ('16', '29300');
INSERT INTO `officecity` VALUES ('16', '29500');
INSERT INTO `officecity` VALUES ('16', '30300');
INSERT INTO `officecity` VALUES ('17', '17000');
INSERT INTO `officecity` VALUES ('18', '200');
INSERT INTO `officecity` VALUES ('18', '600');
INSERT INTO `officecity` VALUES ('19', '7600');
INSERT INTO `officecity` VALUES ('19', '7700');
INSERT INTO `officecity` VALUES ('19', '7800');
INSERT INTO `officecity` VALUES ('19', '7900');
INSERT INTO `officecity` VALUES ('19', '8000');
INSERT INTO `officecity` VALUES ('19', '8400');
INSERT INTO `officecity` VALUES ('20', '8800');
INSERT INTO `officecity` VALUES ('20', '8900');
INSERT INTO `officecity` VALUES ('20', '9100');
INSERT INTO `officecity` VALUES ('20', '9300');
INSERT INTO `officecity` VALUES ('20', '9400');
INSERT INTO `officecity` VALUES ('21', '18300');

-- ----------------------------
-- Table structure for `service`
-- ----------------------------
DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `ServiceType` int(11) NOT NULL AUTO_INCREMENT,
  `ServiceName` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Skills` int(10) unsigned NOT NULL,
  `ServiceCode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `idx` (`ServiceType`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of service
-- ----------------------------
INSERT INTO `service` VALUES ('1', '潔淨', '65541', 'IA');
INSERT INTO `service` VALUES ('2', '滅蟲', '2', 'IB');
INSERT INTO `service` VALUES ('3', '滅蟲噴焗', '16', 'IB');
INSERT INTO `service` VALUES ('4', '租機服务', '65536', 'IC');
INSERT INTO `service` VALUES ('5', '飄盈香服務', '1024', 'IC');
INSERT INTO `service` VALUES ('6', '蠅燈服務', '131072', 'IC');
INSERT INTO `service` VALUES ('7', '什項', '0', 'IC');
INSERT INTO `service` VALUES ('8', '甲醛', '512', 'IC');
INSERT INTO `service` VALUES ('9', '', '4194305', '');
INSERT INTO `service` VALUES ('10', '安装维修拆机', '1048576', 'DBN');
INSERT INTO `service` VALUES ('11', '雾化消毒', '2097152', 'IA');
INSERT INTO `service` VALUES ('12', '鼠臭跟进', '4194304', 'IB');
INSERT INTO `service` VALUES ('13', '常驻灭虫', '2', 'IB');
INSERT INTO `service` VALUES ('14', '二次清洁首次', '4', 'IA');
INSERT INTO `service` VALUES ('15', '送皂液', '8388608', 'INV');
INSERT INTO `service` VALUES ('16', '白蚁', '16777216', 'IB');
INSERT INTO `service` VALUES ('17', '空气净化机租赁', '100663296', 'ID');
INSERT INTO `service` VALUES ('18', '', '0', '');
INSERT INTO `service` VALUES ('19', '', '0', '');

-- ----------------------------
-- Table structure for `staff`
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `StaffID` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StaffName` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StaffDept` int(11) NOT NULL,
  `StaffPost` int(11) NOT NULL,
  `Addr` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `City` int(11) NOT NULL,
  `Office` int(11) NOT NULL,
  `Tel` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mobile` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Line` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Skills` int(10) unsigned NOT NULL,
  `Status` int(11) NOT NULL,
  `Salary` float NOT NULL,
  `StartDate` date NOT NULL,
  `LastDate` date NOT NULL,
  `Remarks` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Gender` int(11) NOT NULL,
  UNIQUE KEY `idx` (`StaffID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES ('400117', '123456', '常俊婷', '4', '25', '', '200', '0', '', '', '', '0', '4', '0', '2014-03-01', '2016-04-08', '', '2');
INSERT INTO `staff` VALUES ('400123', '400123', '李虔基', '1', '13', '中山坦洲十四村绿杨居5栋404', '20000', '2', '13612229763', '13612229763', '', '393274', '4', '3076', '2008-07-07', '2021-04-01', '', '1');
INSERT INTO `staff` VALUES ('400127', '400127', '周东霞', '1', '14', '广东珠海斗门区白蕉镇时代倾城双生花7栋904', '20000', '2', '13411534829', '13411534829', '', '1115141', '4', '0', '2011-09-26', '2020-09-30', '', '2');
INSERT INTO `staff` VALUES ('400134', '123456', '石华锋', '4', '25', '', '200', '0', '', '15822687401', '', '0', '4', '0', '2015-04-28', '2017-02-28', '', '1');
INSERT INTO `staff` VALUES ('400135', '400135', '谢吉超', '4', '25', '中山坦洲十四村百花小镇14栋1单元204', '20000', '2', '13411576081', '13411576081', '', '0', '4', '2350', '2014-11-12', '2018-06-30', '', '1');
INSERT INTO `staff` VALUES ('400186', '400186', '溫智聰', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('400214', '7330', '范春芳', '1', '23', '', '19700', '1', '', '182 1835 7330', '', '0', '4', '0', '2016-02-18', '2017-07-01', '', '2');
INSERT INTO `staff` VALUES ('400250', '4219', '肖化泽', '1', '23', '', '19700', '1', '', '139 2622 4219', '', '0', '4', '0', '2016-03-09', '2018-06-01', '', '1');
INSERT INTO `staff` VALUES ('400252', '400252', '歐陽雄', '4', '25', '', '19700', '1', '', '188 0716 5106', '', '0', '4', '0', '2016-03-14', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400262', '2838', '张志华', '1', '23', '', '19700', '1', '', '137 7856 2838', '', '0', '4', '0', '2016-03-24', '2018-06-01', '', '1');
INSERT INTO `staff` VALUES ('400267', '400267', '连明艳', '6', '36', '', '17000', '17', '', '027-62300082', '', '0', '4', '0', '2014-03-17', '2018-09-30', '', '2');
INSERT INTO `staff` VALUES ('400290', '400290', '王彩霞', '1', '14', '', '100', '0', '', '13661012415', '', '1516559', '4', '2365', '2012-09-03', '2020-04-27', '', '2');
INSERT INTO `staff` VALUES ('400319', '400319', '王德珍', '1', '14', '', '400', '0', '', '18725619745', '', '8455183', '4', '0', '2011-11-08', '2020-12-31', '', '2');
INSERT INTO `staff` VALUES ('400390', '400390', '梁德明', '2', '62', '广东珠海香洲区前进一街9号2单元', '20000', '2', '13709692255', '13709692255', '', '0', '4', '0', '2012-09-04', '2020-03-12', '', '1');
INSERT INTO `staff` VALUES ('400408', '400408', '王俊杰', '4', '25', '', '17000', '17', '', '', '', '0', '4', '0', '2015-09-07', '2017-02-16', '', '2');
INSERT INTO `staff` VALUES ('400433', '400433', '林昌红', '1', '14', '', '21400', '4', '', '13672784456', '', '3618815', '4', '0', '2010-12-22', '2021-02-06', '', '1');
INSERT INTO `staff` VALUES ('400453', '6657', '谢金伟', '1', '23', '', '19700', '1', '', '180 7357 6657', '', '0', '4', '0', '2016-04-26', '2017-01-01', '', '1');
INSERT INTO `staff` VALUES ('400457', '400457', '李欣', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('400465', '8767', '陈红青', '1', '23', '', '19700', '1', '', '136 0978 8767', '', '0', '4', '0', '2016-05-12', '2017-01-01', '', '2');
INSERT INTO `staff` VALUES ('400473', '400473', '黃增敏', '4', '25', '', '19700', '0', '', '135 3942 5134', '', '0', '4', '0', '2016-05-20', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400523', '400523', '张立军', '1', '14', '珠海南屏十二丰盛园187号', '20000', '2', '15919227927', '15919227927', '', '1246215', '4', '0', '2016-05-24', '2020-09-30', '', '1');
INSERT INTO `staff` VALUES ('400540', '6290', '骆留明', '1', '12', '', '19700', '1', '', '138 2645 6290', '', '0', '4', '0', '2010-09-29', '2018-06-01', '', '1');
INSERT INTO `staff` VALUES ('400541', '400541', '陳翠花', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2009-01-01', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('400554', '400554', '李聰', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2013-04-26', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400556', '0036', '梁军', '1', '23', '', '19700', '1', '', '151 1214 0036', '', '0', '4', '0', '2013-07-22', '2017-01-01', '', '1');
INSERT INTO `staff` VALUES ('400562', '0091', '黄秀贞', '1', '23', '', '19700', '1', '', '159 0204 0091', '', '0', '4', '0', '2014-02-19', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('400568', '400568', '梁肖玲', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2014-05-26', '2018-01-01', '', '2');
INSERT INTO `staff` VALUES ('400576', '400576', '馮健濤', '4', '25', '', '19700', '1', '', '137 1114 0141', '', '0', '4', '0', '2014-11-25', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400582', '400582', '鄭華壽', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('400583', '3542', '李冬根', '1', '23', '', '19700', '1', '', '158 1884 3542', '', '0', '4', '0', '2015-05-08', '2017-01-01', '', '1');
INSERT INTO `staff` VALUES ('400586', '2927', '高亮', '1', '23', '', '19700', '1', '', '189 7948 2927', '', '0', '4', '0', '2015-07-20', '2017-01-01', '', '1');
INSERT INTO `staff` VALUES ('400590', '400590', '陳亮達', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('400597', '6810', '梁文富', '1', '23', '', '19700', '1', '', '134 5029 6810', '', '0', '4', '0', '2015-10-22', '2017-01-01', '', '1');
INSERT INTO `staff` VALUES ('400638', '400638', '盧兵兵', '4', '25', '', '19700', '1', '', '188 9843 0685', '', '0', '4', '0', '2016-06-21', '2018-06-01', '', '1');
INSERT INTO `staff` VALUES ('400664', '5162', '廖志军', '1', '23', '', '19700', '1', '', '153 7403 5162', '', '0', '4', '0', '2016-07-12', '2017-01-01', '', '1');
INSERT INTO `staff` VALUES ('400668', '1234', '许建荣', '1', '23', '', '23600', '9', '', '15802845582', '', '16777215', '4', '0', '2016-07-27', '2020-09-30', '', '1');
INSERT INTO `staff` VALUES ('400673', '400673', '古憶憶', '4', '25', '', '19700', '1', '', '134 3029 1576 ', '', '0', '4', '0', '2016-08-10', '2018-01-01', '', '2');
INSERT INTO `staff` VALUES ('400687', '123456', '齐红欢', '4', '25', '', '200', '0', '', '', '', '0', '4', '0', '2016-08-15', '2018-03-31', '', '2');
INSERT INTO `staff` VALUES ('400716', '400716', '陳敏', '4', '25', '', '19700', '1', '', '188 2609 9270', '', '0', '4', '0', '2016-09-19', '2018-01-01', '', '2');
INSERT INTO `staff` VALUES ('400717', '400717', '陳基豪', '4', '25', '', '19700', '1', '', '159 8904 9489', '', '0', '4', '0', '2016-09-24', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400720', '400720', '李利偉', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2016-09-21', '2018-08-01', '', '1');
INSERT INTO `staff` VALUES ('400731', '400731', '謝志強', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2016-09-26', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400738', '400738', '何俊健', '4', '25', '', '19700', '1', '', '134 1636 7416', '', '0', '4', '0', '2016-10-05', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400746', '1234', '伊帆', '4', '25', '成华区建设北路二段五号', '23600', '9', '', '13688403641', '', '0', '4', '0', '2016-10-11', '2018-01-15', '', '2');
INSERT INTO `staff` VALUES ('400763', '9071', '张琪', '1', '23', '', '19700', '1', '', '188 8200 9071', '', '0', '4', '0', '2016-10-28', '2018-06-01', '', '1');
INSERT INTO `staff` VALUES ('400801', '1234', '谢松霖', '4', '68', '四川省绵阳市游仙区松垭镇龙洞子村3组82号', '23600', '9', '', '15884506964', '', '0', '4', '0', '2017-01-05', '2020-01-20', '', '1');
INSERT INTO `staff` VALUES ('400811', '4200', '贾东利', '1', '23', '', '19700', '1', '', '131 2935 4200', '', '0', '4', '0', '2017-02-06', '2017-12-01', '', '1');
INSERT INTO `staff` VALUES ('400815', '1053', '侯蓬根', '1', '23', '', '19700', '1', '', '186 1308 1053', '', '0', '4', '0', '2017-02-16', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400829', '400829', '陳兆麟', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2017-02-27', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400830', '8188', '李时峰', '1', '23', '', '19700', '1', '', '181 7397 8188', '', '0', '4', '0', '2017-02-28', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('400841', '400841', '潘洪斌', '4', '25', '', '19700', '1', '', '134 3029 1576', '', '0', '4', '0', '2017-03-06', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400844', '400844', '陈潇鸿', '4', '25', '珠海香洲兴华路33号18栋翠香街道办事处紫荆居委会', '20000', '2', '18820112774', '18820112774', '', '0', '4', '2350', '2017-02-22', '2018-08-31', '', '1');
INSERT INTO `staff` VALUES ('400868', '400868', '王康林', '4', '25', '', '28900', '0', '', '', '', '0', '4', '0', '2017-02-20', '2017-09-15', '', '1');
INSERT INTO `staff` VALUES ('400870', '400870', '柯獻欣', '4', '25', '', '19700', '1', '', '188 2608 6439', '', '0', '4', '0', '2017-03-27', '2018-06-01', '', '1');
INSERT INTO `staff` VALUES ('400905', '5960', '薛玲娟', '1', '23', '', '19700', '0', '', '188 1396 5960', '', '196611', '4', '0', '2017-05-08', '2020-12-18', '', '2');
INSERT INTO `staff` VALUES ('400923', '400923', '黄全忠-离职', '1', '14', '', '19900', '0', '', '13825228156 ', '', '4587546', '4', '0', '2017-05-27', '2021-04-20', '', '1');
INSERT INTO `staff` VALUES ('400946', '7396', '谭文勇', '1', '22', '', '19700', '1', '', '186 8886 7396', '', '0', '4', '0', '2017-06-12', '2017-12-01', '', '1');
INSERT INTO `staff` VALUES ('400961', '6347', '汤明', '1', '22', '', '19700', '1', '', '137 1171 6347', '', '0', '4', '0', '2017-06-26', '2018-01-01', '', '1');
INSERT INTO `staff` VALUES ('400967', '400967', '鄭天山', '4', '25', '', '19700', '0', '', '158 2023 2721', '', '0', '4', '0', '2017-07-05', '2018-06-01', '', '1');
INSERT INTO `staff` VALUES ('400992', '400992', '金汉成', '4', '25', '', '17000', '17', '', '', '', '0', '4', '0', '2017-07-17', '2017-11-01', '', '1');
INSERT INTO `staff` VALUES ('400995', '400995', '邓俊坚', '4', '68', '', '20200', '0', '', '18565589050', '', '512', '4', '0', '2017-07-10', '2021-02-28', '', '1');
INSERT INTO `staff` VALUES ('401003', '1234', '黄正洪', '4', '25', '成都市青羊区培风横街274好光华嘉苑1-1-303', '23600', '9', '', '15756284638', '', '0', '4', '0', '2017-07-01', '2017-11-11', '', '1');
INSERT INTO `staff` VALUES ('401004', '1234', '冯宝康', '4', '25', '四川省成都市犀浦镇泰山二巷23号201', '23600', '9', '', '15756324014', '', '0', '4', '0', '2017-07-06', '2017-12-13', '', '1');
INSERT INTO `staff` VALUES ('401010', '401010', '吴玉辉', '4', '25', '', '17000', '17', '', '', '', '0', '4', '0', '2017-08-08', '2017-11-01', '', '1');
INSERT INTO `staff` VALUES ('401028', '2076', '刘芳', '1', '23', '', '19700', '1', '', '131 1241 2076', '', '0', '4', '0', '2017-08-07', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('401052', '401052', '连军佐', '1', '14', '', '21400', '0', '', '13531808430', '', '2557434', '4', '0', '2017-08-18', '2021-03-01', '', '1');
INSERT INTO `staff` VALUES ('401079', '401079', '李庆红', '1', '14', '', '100', '6', '', '15321839066', '', '1508367', '4', '1200', '2017-09-11', '2020-05-27', '', '2');
INSERT INTO `staff` VALUES ('401086', '0000', '劉小蘭', '4', '25', '', '19700', '0', '', '134 2055 7618', '', '0', '4', '0', '2017-09-18', '2018-01-01', '', '2');
INSERT INTO `staff` VALUES ('401091', '401091', '刁云刚', '4', '25', '', '17000', '17', '', '15527632553', '', '0', '4', '0', '2017-09-27', '2018-04-30', '', '1');
INSERT INTO `staff` VALUES ('401123', '401123', '杨继荣', '1', '14', '', '7600', '0', '', '18168902935', '', '16725279', '1', '3200', '2017-10-17', '2020-10-11', '', '1');
INSERT INTO `staff` VALUES ('401143', '7602', '陈艳敏', '1', '22', '', '19700', '1', '', '136 5071 7602', '', '0', '4', '0', '2017-11-16', '2018-06-01', '', '2');
INSERT INTO `staff` VALUES ('402064', '402064', '梁丽芳', '4', '25', '广东中山三乡金涌大道万象郡10栋', '20000', '2', '13326696263', '13326696263', '', '0', '4', '2350', '2017-12-04', '2019-07-18', '', '2');
INSERT INTO `staff` VALUES ('402068', '402068', '张兵(离职）', '1', '23', '', '19900', '0', '', '15012625066 ', '', '6684690', '4', '0', '2017-11-22', '2020-04-01', '', '1');
INSERT INTO `staff` VALUES ('402081', '1234', '杨晓凤', '4', '25', '四川省成都市成华区荆竹西路348号', '23600', '9', '', '13882191437', '', '0', '4', '0', '2017-12-08', '2018-02-07', '', '2');
INSERT INTO `staff` VALUES ('402082', '1234', '李定一', '4', '25', '成都市金牛区五里墩东街143号36栋1单元7号', '23600', '9', '', '13308070557', '', '0', '4', '0', '2017-12-13', '2018-01-17', '', '1');
INSERT INTO `staff` VALUES ('402087', '402087', '郭建武', '1', '14', '', '100', '6', '', '15201244398', '', '1508367', '4', '1315', '2017-12-11', '2020-11-02', '', '1');
INSERT INTO `staff` VALUES ('402095', '402095', '朱鹏', '4', '25', '', '28900', '0', '', '18092695778', '', '0', '4', '0', '2017-12-22', '2018-07-31', '', '1');
INSERT INTO `staff` VALUES ('402117', '9881', '陈美玲', '1', '23', '', '19700', '1', '', '181 0262 9881', '', '0', '4', '0', '2018-01-19', '2018-12-15', '', '2');
INSERT INTO `staff` VALUES ('402120', '402120', '李德全（离职）', '1', '23', '', '19900', '0', '', '18814451004 ', '', '4587522', '4', '0', '2018-01-23', '2020-06-14', '', '1');
INSERT INTO `staff` VALUES ('402161', '6029', '熊耀', '1', '22', '', '19700', '1', '', '132 2665 6029', '', '0', '4', '0', '2018-03-05', '2018-06-01', '', '1');
INSERT INTO `staff` VALUES ('402185', 'lbs123456', '李斌', '4', '25', '', '20200', '0', '', '15002124047', '', '0', '4', '0', '2018-03-05', '2020-10-16', '', '1');
INSERT INTO `staff` VALUES ('402197', '0000', '高清容', '4', '25', '', '19700', '0', '', '188 9843 0685', '', '0', '4', '0', '2018-04-07', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('402206', '123456', '李顺', '1', '23', '', '20200', '0', '', '13169996024', '', '14627855', '4', '0', '2018-04-02', '2020-05-13', '', '1');
INSERT INTO `staff` VALUES ('402278', '402278', '孙军', '1', '22', '', '300', '0', '', '', '', '393226', '4', '0', '2018-05-30', '2020-04-07', '', '1');
INSERT INTO `staff` VALUES ('402292', '402292', '李俊杰（离职）', '1', '23', '', '19900', '0', '', '13088137965 ', '', '65537', '4', '0', '2018-06-29', '2020-06-01', '', '1');
INSERT INTO `staff` VALUES ('402296', '402296', '吴同同', '3', '34', '', '300', '3', '', '', '', '0', '4', '0', '2018-06-20', '2020-11-30', '', '2');
INSERT INTO `staff` VALUES ('402314', '402314', '黄轩', '8', '74', '', '21300', '11', '', '13510353155', '', '0', '4', '0', '2018-06-19', '2020-11-30', '', '1');
INSERT INTO `staff` VALUES ('402321', '402321', '杨立君', '1', '23', '', '21400', '0', '', '13726076704', '', '3606010', '4', '0', '2018-07-10', '2020-05-31', '', '1');
INSERT INTO `staff` VALUES ('402338', '402338', '巫伟宝', '1', '23', '珠海香洲新竹花园10栋203房', '20000', '2', '15976944036', '15976944036', '', '1508378', '4', '0', '2018-07-25', '2021-03-02', '', '1');
INSERT INTO `staff` VALUES ('402340', '5213', '钟远泉', '1', '22', '', '19700', '1', '', '152 1805 5213', '', '64', '4', '0', '2018-07-26', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402346', '402346', '蒋赛花（离职）', '1', '23', '', '19900', '0', '', '18770896309 ', '', '65537', '4', '0', '2018-08-07', '2020-06-01', '', '2');
INSERT INTO `staff` VALUES ('402354', '1234', '苟海洋', '4', '25', '成都市新都区工业大道东段363号丽水金都', '23600', '9', '', '13552817256', '', '0', '4', '0', '2018-07-14', '2018-10-31', '', '1');
INSERT INTO `staff` VALUES ('402389', '402389', '梁浩陽', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2017-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402390', '402390', '莫艺婷', '3', '34', '', '19700', '1', '', '15876544537', '', '0', '4', '0', '2018-09-05', '2021-04-14', '', '2');
INSERT INTO `staff` VALUES ('402412', '888888', '瞿吉凤（离职）', '1', '23', '', '19900', '0', '', '18820983183 ', '', '6684690', '4', '0', '2018-09-18', '2020-05-01', '', '1');
INSERT INTO `staff` VALUES ('402446', '402446', '陈俊杰', '4', '25', '', '20200', '0', '', '13528995620', '', '512', '4', '0', '2018-11-05', '2020-08-25', '', '1');
INSERT INTO `staff` VALUES ('402455', '402455', '黄浪', '4', '25', '', '17000', '17', '', '18971321584', '', '0', '4', '0', '2018-11-07', '2018-12-07', '', '1');
INSERT INTO `staff` VALUES ('402456', '402456', '赵丽侠', '4', '25', '江苏省南京市浦口区浦仁村21栋205', '7500', '13', '', '13770868878', '', '16655360', '1', '0', '2018-11-01', '2020-03-23', '', '2');
INSERT INTO `staff` VALUES ('402460', '402460', '王永博', '4', '25', '', '28900', '0', '13002939910', '', '', '0', '4', '0', '2018-11-14', '2019-07-19', '', '1');
INSERT INTO `staff` VALUES ('402488', '0000', '葉靜姬', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('402489', '0000', '鄧 偉', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('402490', '0000', '陳宏鵬', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402491', '402491', '何秀婷', '4', '25', '', '19700', '1', '', '', '', '0', '1', '0', '2010-01-01', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('402492', '0000', '歐培清', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('402493', '0000', '甄侃迪', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2017-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402494', '402494', '賴國聰', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402495', '0000', '羅建華', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402496', '0000', '馮德泉', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402497', '0000', '謝澤超', '4', '25', '402497', '19700', '0', '', '', '', '0', '4', '0', '2010-01-02', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402498', '0000', '李展華', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402499', '0000', '譚白玉', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('402500', '0000', '黃超平', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402501', '0000', '盧金麗', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('402502', '0000', '陳紅玲', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('402503', '0000', '劉中衛', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402504', '0000', '陳海霞', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '2');
INSERT INTO `staff` VALUES ('402505', '0000', '劉高強', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2010-01-02', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402506', '402506', '吳賢德', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2018-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402507', '402507', '郭尚茂', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402508', '402508', '梅代方', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402509', '402509', '李子健', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2010-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402511', '402511', '彭祖英', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2005-01-01', '2018-10-01', '', '2');
INSERT INTO `staff` VALUES ('402512', '402512', '潘燕秋', '4', '25', '', '19700', '1', '', '', '', '0', '4', '0', '2005-01-01', '2018-01-01', '', '2');
INSERT INTO `staff` VALUES ('402513', '0000', '曾劍恆', '4', '25', '', '19700', '0', '', '', '', '0', '4', '0', '2005-01-01', '2018-12-01', '', '1');
INSERT INTO `staff` VALUES ('402532', '402532', '赵雪松', '1', '22', '', '400', '0', '', '15683832207', '', '8455183', '4', '0', '2018-12-16', '2020-09-06', '', '1');
INSERT INTO `staff` VALUES ('402533', '402533', '濮公博', '4', '25', '', '17000', '17', '', '15971417803', '', '0', '4', '0', '2019-01-08', '2019-06-15', '', '1');
INSERT INTO `staff` VALUES ('402540', '402540', '汤武松', '1', '22', '', '300', '0', '', '', '', '459791', '4', '0', '2019-01-11', '2020-02-29', '', '1');
INSERT INTO `staff` VALUES ('402551', '402551', '王红远', '1', '22', '', '300', '0', '', '', '', '459791', '4', '0', '2019-01-21', '2020-02-29', '', '1');
INSERT INTO `staff` VALUES ('402595', '402595', '梁恒来', '1', '23', '', '20200', '0', '', '13715404862', '', '14627855', '4', '0', '2019-03-13', '2020-06-01', '', '1');
INSERT INTO `staff` VALUES ('402602', '402602', '杨福德（离职）', '9', '60', '', '19900', '0', '', '15302675122', '', '0', '4', '0', '2019-03-20', '2020-07-20', '', '1');
INSERT INTO `staff` VALUES ('402613', '402613', '吴大新', '1', '23', '', '100', '6', '', '15101672606', '', '1508367', '4', '1200', '2019-03-20', '2020-07-01', '', '1');
INSERT INTO `staff` VALUES ('402639', '123456', '郭全利', '4', '25', '', '200', '0', '', '', '', '0', '4', '0', '2019-04-01', '2019-11-01', '', '2');
INSERT INTO `staff` VALUES ('402641', '123456', '王嘉伟', '4', '68', '', '200', '0', '', '', '', '0', '4', '0', '2019-04-08', '2019-06-04', '', '1');
INSERT INTO `staff` VALUES ('402674', '1234', '唐朝州', '4', '25', '四川省成都市金牛区五块石', '23600', '9', '', '13290088825', '', '0', '4', '0', '2019-04-22', '2020-01-15', '', '1');
INSERT INTO `staff` VALUES ('402706', '402706', '何国健', '4', '25', '', '21800', '0', '', '13543357294', '', '0', '4', '0', '2019-06-19', '2020-04-30', '', '1');
INSERT INTO `staff` VALUES ('402714', '402714', '高超', '4', '25', '珠海唐家华发人才公寓', '20000', '2', '13297087659', '13297087659', '', '0', '4', '0', '2019-06-28', '2021-01-12', '', '1');
INSERT INTO `staff` VALUES ('402715', '402715', '黄敏', '4', '25', '南京市浦口区浦厂二村3栋602', '7500', '0', '', '18761607904', '', '12530688', '1', '0', '2019-06-24', '2020-03-31', '', '2');
INSERT INTO `staff` VALUES ('402718', '402718', '王勋顺', '1', '22', '', '20200', '0', '', '13202920382', '', '4194303', '4', '0', '2019-07-08', '2020-05-01', '', '1');
INSERT INTO `staff` VALUES ('402721', '402721', '陈强', '1', '22', '', '300', '3', '', '', '', '459791', '4', '0', '2019-07-08', '2020-04-30', '', '1');
INSERT INTO `staff` VALUES ('402722', '123456', '李建华', '1', '23', '', '20300', '0', '', '13672922342', '', '16200735', '4', '0', '2019-07-08', '2020-10-31', '', '1');
INSERT INTO `staff` VALUES ('402737', '1234', '林汇东', '4', '25', '四川省成都市金牛区五块石', '23600', '9', '', '18882672886', '', '0', '4', '0', '2019-07-02', '2019-12-14', '', '1');
INSERT INTO `staff` VALUES ('402751', '402751', '符巧钢', '4', '24', '', '20000', '2', '17608964685', '17608964685', '', '0', '4', '0', '2019-08-07', '2021-05-01', '晋升地区主管，从广州调人事资料至珠海，需更改ID号401144', '1');
INSERT INTO `staff` VALUES ('402768', '402768', '林涛', '4', '25', '广东珠海斗门井岸南苑东97号', '20000', '2', '18218227485', '18218227485', '', '0', '4', '0', '2019-08-26', '2020-05-31', '', '1');
INSERT INTO `staff` VALUES ('402787', '402787', '沈灵运', '9', '59', '玄武区曹后二三村18栋401', '7500', '13', '', '17366227697', '', '12566034', '1', '0', '2019-09-16', '2020-10-12', '', '1');
INSERT INTO `staff` VALUES ('402789', '402789', '郑景澎（离职）', '1', '23', '', '19900', '0', '', '15626491868 ', '', '4587522', '4', '0', '2019-09-17', '2020-06-01', '', '1');
INSERT INTO `staff` VALUES ('402823', '402823', '孟向阳', '4', '25', '', '28900', '0', '', '13389246887', '', '0', '4', '2000', '2019-10-23', '2020-05-31', '', '1');
INSERT INTO `staff` VALUES ('402824', '402824', '陈浪', '1', '22', '广东省中山市三乡镇', '20000', '2', '13672775427', '13672775427', '', '3', '4', '1200', '2019-10-25', '2020-08-31', '', '1');
INSERT INTO `staff` VALUES ('402826', '402826', '王文文', '4', '25', '', '28900', '0', '', '15891681996', '', '0', '4', '2000', '2019-10-28', '2021-01-31', '', '2');
INSERT INTO `staff` VALUES ('402830', '402830', '张萍', '3', '34', '', '300', '3', '', '', '', '0', '4', '0', '2019-10-23', '2020-09-30', '', '2');
INSERT INTO `staff` VALUES ('402832', '402832', '徐柱华（离职）', '1', '22', '', '19900', '0', '', '13425100432', '', '4587522', '4', '0', '2019-11-07', '2020-04-01', '', '1');
INSERT INTO `staff` VALUES ('402833', '402833', '王红岩', '1', '22', '', '100', '6', '', '15901091845', '', '0', '4', '1200', '2019-11-01', '2020-04-14', '', '1');
INSERT INTO `staff` VALUES ('402837', '402837', '陈静意（离职）', '9', '29', '', '19900', '7', '', '15848680020', '', '0', '4', '0', '2019-11-11', '2021-02-25', '', '1');
INSERT INTO `staff` VALUES ('402853', '402853', '黄武克', '1', '23', '南宁良庆区绵秀路绵秀南三巷40号402房', '21800', '0', '', '18934706887', '', '16725247', '4', '0', '2019-12-02', '2021-03-10', '', '1');
INSERT INTO `staff` VALUES ('402858', '402858', '衣丽沙', '3', '34', '', '300', '3', '', '', '', '0', '4', '0', '2019-11-29', '2020-02-29', '', '2');
INSERT INTO `staff` VALUES ('402865', '402865', '赵琼会', '1', '22', '', '400', '0', '', '15523207608', '', '65537', '4', '0', '2019-12-13', '2020-11-01', '', '2');
INSERT INTO `staff` VALUES ('402868', '402868', '王将', '1', '22', '', '300', '3', '', '', '', '459791', '4', '0', '2019-12-09', '2020-03-09', '', '1');
INSERT INTO `staff` VALUES ('402871', '402871', '管春明', '1', '22', '坦洲交界', '20000', '2', '15918710926', '15918710926', '', '3', '4', '0', '2019-12-24', '2020-06-17', '', '1');
INSERT INTO `staff` VALUES ('402887', '402887', '黄莹', '2', '70', '', '21800', '8', '', '18697936283', '', '0', '4', '0', '2020-03-30', '2020-12-01', '', '2');
INSERT INTO `staff` VALUES ('402891', '123456', '刘志财', '1', '22', '', '20300', '0', '', '', '', '0', '4', '0', '2020-04-10', '2020-04-15', '', '1');
INSERT INTO `staff` VALUES ('402898', '402898', '杨素洪', '1', '22', '', '7600', '0', '', '15895363853', '', '9110531', '1', '3200', '2020-04-14', '2020-01-01', '', '2');
INSERT INTO `staff` VALUES ('402908', '402908', '李小平（离职）', '4', '25', '', '19900', '0', '', '', '', '0', '4', '0', '2020-05-13', '2020-06-10', '', '1');
INSERT INTO `staff` VALUES ('402914', '402914', '林涛', '4', '25', '广东省珠海市斗门区井岸镇南苑东97号', '20000', '2', '18218227485', '18218227485', '', '0', '4', '0', '2020-06-01', '2020-09-01', '', '1');
INSERT INTO `staff` VALUES ('402918', '402918', '郑泳欣', '4', '25', '珠海市香洲区海港路70号', '20000', '2', '13075698253', '13075698253', '', '0', '4', '0', '2020-06-06', '2020-07-31', '', '2');
INSERT INTO `staff` VALUES ('402926', '1234', '宋鹏', '11', '63', '四川省成都市双流区长顺路四段顺和苑86号', '23600', '9', '19150244262', '19150244262', 'rocsong.cd@lbsgroup.com.cn', '0', '4', '4350', '2020-06-15', '2020-09-14', '', '1');
INSERT INTO `staff` VALUES ('402932', '1234', '郭艳洁', '1', '22', '成都市锦江区点将台45号', '23600', '9', '', '15908141571', '', '10036255', '4', '2800', '2020-07-01', '2021-03-31', '', '2');
INSERT INTO `staff` VALUES ('402939', '123456', '孙见', '1', '22', '', '8800', '20', '', '18856821264', '', '0', '4', '0', '2020-07-30', '2020-08-28', '', '1');
INSERT INTO `staff` VALUES ('402940', '402940', '颜建华', '11', '64', '广西南宁市青秀区民族大道63号', '21800', '0', '', '13435264606', '', '33554431', '4', '0', '2016-07-07', '2021-04-15', '', '2');
INSERT INTO `staff` VALUES ('402951', '402951', '高宇', '1', '22', '清秀区，仙湖经济开发区，环湖西路14号2单元，6楼', '21800', '0', '13789612362', '13789612362', '', '10159107', '4', '0', '2020-08-19', '2020-11-17', '', '1');
INSERT INTO `staff` VALUES ('402961', '402961', '李森荣', '1', '22', '', '20300', '0', '', '18948860560', '', '0', '4', '0', '2020-09-10', '2020-10-01', '', '1');
INSERT INTO `staff` VALUES ('402964', '402964', '吴嘉劲', '4', '25', '', '21300', '11', '', '18925886198', '', '0', '4', '0', '2021-03-01', '2021-03-01', '', '1');
INSERT INTO `staff` VALUES ('402971', '402971', '周梓健', '4', '25', '', '20200', '0', '', '13928656948', '', '0', '4', '0', '2020-09-15', '2020-10-07', '', '1');
INSERT INTO `staff` VALUES ('402978', '402978', '谢利佳（离职）', '1', '22', '', '19900', '0', '', '19879187776', '', '4456466', '4', '0', '2020-10-14', '2021-02-20', '', '1');
INSERT INTO `staff` VALUES ('402990', '402990', '杨勇', '4', '25', '莲湖区红光路简家村36号', '28900', '0', '', '15829203315', '', '0', '4', '2000', '2020-10-20', '2021-01-28', '', '1');
INSERT INTO `staff` VALUES ('403009', '403009', '姚伟琴-离职', '7', '37', '', '19900', '7', '', '18823775514', '', '0', '4', '0', '2020-10-29', '2021-04-09', '', '2');
INSERT INTO `staff` VALUES ('403013', '403013', '叶素伶', '2', '19', '广西南宁市西乡塘区友爱路西五巷34号', '21800', '8', '17877091063', '17877091063', '', '0', '4', '0', '2020-10-29', '2020-12-16', '', '2');
INSERT INTO `staff` VALUES ('403028', '403028', '谭智帮', '4', '25', '广东省珠海市香洲区界涌东闸街19号', '20000', '2', '', '13016342784', '', '0', '4', '0', '2020-11-25', '2021-05-12', '', '1');
INSERT INTO `staff` VALUES ('403029', '403029', '罗重姣', '1', '22', '', '21800', '0', '13657716707', '13657716707', '', '721923', '4', '0', '2020-12-01', '2020-12-08', '', '2');
INSERT INTO `staff` VALUES ('403031', '403031', '周立权', '1', '22', '', '300', '3', '13641585397', '', '', '66563', '4', '0', '2020-12-04', '2021-03-01', '', '1');
INSERT INTO `staff` VALUES ('403057', '403057', '卢文清', '4', '25', '', '20300', '0', '', '13427442775', '', '0', '4', '0', '2021-04-06', '2021-04-05', '', '2');
INSERT INTO `staff` VALUES ('403075', '403075', '彭速才-离职', '1', '22', '', '19900', '0', '', '17373003128', '', '66561', '4', '0', '2021-03-02', '2021-04-29', '', '1');
INSERT INTO `staff` VALUES ('403081', '1234', '鄢志明', '1', '22', '成都市金牛区一环路北一段330号', '23600', '9', '', '18280030181', '', '14234655', '4', '0', '2021-03-05', '2021-04-21', '', '2');
INSERT INTO `staff` VALUES ('403087', '403087', '刘声建-离职', '9', '29', '', '19900', '0', '', '13530539473', '', '0', '4', '0', '2021-03-15', '2021-04-22', '', '1');
INSERT INTO `staff` VALUES ('403093', '403093', '刘晓芬－离职', '1', '22', '', '19900', '0', '', '13527775086', '', '4587538', '4', '0', '2021-03-16', '2021-04-15', '', '1');
INSERT INTO `staff` VALUES ('403094', '403094', '王翠林', '1', '22', '', '17000', '0', '027-62300082', ' 13986068186', '', '15139871', '1', '3200', '2021-03-01', '2022-03-01', '', '2');
INSERT INTO `staff` VALUES ('403103', '123123', '周有杰', '1', '22', '', '21800', '0', '', '13068638173', '', '0', '1', '0', '2021-03-29', '2021-05-25', '', '1');
INSERT INTO `staff` VALUES ('403117', '403117', '张敬成-离职', '1', '22', '', '19900', '0', '13798555718', '13798555718', '', '7929907', '4', '0', '2021-04-14', '2021-05-05', '', '1');
INSERT INTO `staff` VALUES ('HUANG', 'HUANG', '黄轩', '11', '66', '', '21400', '4', '', '13510353155', '', '0', '4', '0', '2020-01-01', '2020-12-01', '', '1');

-- ----------------------------
-- Table structure for `svc_queue`
-- ----------------------------
DROP TABLE IF EXISTS `svc_queue`;
CREATE TABLE `svc_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rpt_desc` varchar(250) NOT NULL,
  `req_dt` datetime DEFAULT NULL,
  `fin_dt` datetime DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `status` char(1) NOT NULL,
  `rpt_type` varchar(10) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rpt_content` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of svc_queue
-- ----------------------------

-- ----------------------------
-- Table structure for `svc_queue_param`
-- ----------------------------
DROP TABLE IF EXISTS `svc_queue_param`;
CREATE TABLE `svc_queue_param` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `queue_id` int(10) unsigned NOT NULL,
  `param_field` varchar(50) NOT NULL,
  `param_value` varchar(500) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of svc_queue_param
-- ----------------------------

-- ----------------------------
-- Table structure for `svc_queue_user`
-- ----------------------------
DROP TABLE IF EXISTS `svc_queue_user`;
CREATE TABLE `svc_queue_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `queue_id` int(10) unsigned NOT NULL,
  `username` varchar(30) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of svc_queue_user
-- ----------------------------